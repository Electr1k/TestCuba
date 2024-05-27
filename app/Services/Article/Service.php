<?php

namespace App\Services\Article;

use App\Components\ImportWikiClient;
use App\Models\Article;
use App\Models\Word;
use DOMDocument;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;


/**
 * Класс - сервис для взаимодействия со статьями
 */
class Service
{

    /**
     * Метод для импорт статьи по ключевому слову
     * Метод делает запрос к wiki, вызывет метод для парсинга html и сохраняет статью в базу данных
     * @param string $word - ключевое слово (название статьи))
     * @return Article | null - Возвращает либо созданную модель, либо null
     */
    public function store(string $word): Article | null
    {
        $import = new ImportWikiClient();
        // Делаем запрос к wiki
        try {
            $response = $import->client->request('GET', "?action=parse&format=json&page=$word");
        }
        catch (GuzzleException $e){
            return null;
        }
        if ($response->getStatusCode() !== 200) return null;

        // Декодируем json ответ в ассоциативный массив
        $json = json_decode($response->getBody()->getContents(),true);
        $html = $json['parse']['text']['*'];

        // Находим объем занимаемой памяти KB
        $size = round(strlen($html)/(1024),1);
        // Получаем чистый текст и ассоциативный массив количества слов
        [$plainText, $wordCount] = $this->parseHTML($html);
        DB::beginTransaction();
        try {
            // Добавляем статьи и слова в БД
            $articleData = [
                'title' => $json['parse']['title'],
                'url' => env("WIKI_BASE_URL").$word,
                'size' => $size,
                'plain_text' => $plainText];
            $article = Article::create($articleData);
            foreach ($wordCount as $word => $count) {
                Word::create([
                    'article_id' => $article->id,
                    'word' => $word,
                    'count' => $count,
                    ]);
            }
            DB::commit();
            return $article;
        }
        catch (\Exception $e){
            DB::rollBack();
        }
        return null;
    }


    /**
     * Метод для парсинга текста из HTML
     * Метод убирает все теги и подсчитывает количество вхождений кадого слова
     * @param string $html - исходный HTML
     * @return array - Возвращает массив,
     * 0 элемент - plain text, 1 элемент - ассоциативный массив ['слово' => 'количество вхождений']
     */
    private function parseHTML(string $html): array
    {
        $dom = new DOMDocument();
        // Убираем все теги
        @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        // Удаляем все теги style
        $styleElements = $dom->getElementsByTagName('style');
        while ($styleElement = $styleElements->item(0)) {
            $styleElement->parentNode->removeChild($styleElement);
        }
        // Заменяем все \n
        $plaintText = preg_replace( "/\n\s+/", " ", rtrim(html_entity_decode(strip_tags($dom->saveHTML($dom)))));

        // Разбиваем строку на слова атомы
        $words = preg_split("/[^а-яА-ЯA-Za-z0-9]/u", mb_convert_case($plaintText, MB_CASE_LOWER, "UTF-8"));

        // Убираем пустые строки и подсчитываем количество вхождений
        $wordCount = array_count_values(array_filter($words, static function ($value) { return trim($value) !== ''; }));
        return [$plaintText, $wordCount];
    }

    /**
     * Метод для полчения всех статей
     * Метод получает все статьи из БД и возвращает их
     * @return Collection - Возвращает коллекцию статей
     */
    public function index(): Collection
    {
        return Article::all();
    }

    /**
     * Метод для поиска статей, в которо содержится ключевое слово
     * @param string $word - ключевое слово (слово атом)
     * @return Collection - Возвращает коллекцию из статей и слова, с количеством вхождений
     */
    public function search(string $word): \Illuminate\Support\Collection
    {
        return DB::table('articles')
            ->join('words', 'articles.id', '=', 'words.article_id')
            ->where('word', 'like', $word)
            ->orderBy('count', 'DESC')
            ->get();
    }
}
