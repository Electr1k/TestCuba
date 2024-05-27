<?php

namespace App\Services\Article;

use App\Components\ImportWikiClient;
use App\Models\Article;
use App\Models\Word;
use DOMDocument;
use Illuminate\Support\Facades\DB;

class Service
{
    public function store(string $word): Article | null
    {
        $import = new ImportWikiClient();
        try {
            $response = $import->client->request('GET', "?action=parse&format=json&page=$word");
        }
        catch (\Exception $e){
            var_dump($e->getMessage());
            return null; }
        if ($response->getStatusCode() !== 200) return null;
        $json = json_decode($response->getBody()->getContents(),true);
        $size = round(strlen($json['parse']['text']['*'])/(8*1024),1);
        [$plainText, $wordCount] = $this->parseHTML($json['parse']['text']['*']);
        DB::beginTransaction();
        try {
            $articleData = ['title' => $json['parse']['title'], 'url' => env("WIKI_BASE_URL").$word, 'size' => $size, 'plain_text' => $plainText];
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

    private function parseHTML(string $html): array
    {
        $dom = new DOMDocument();
        @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        // Получаем основной контент
        $content = $dom->getElementById('bodyContent');
        $styleElements = $dom->getElementsByTagName('style');
        // Удаляем каждый тег style
        while ($styleElement = $styleElements->item(0)) {
            $styleElement->parentNode->removeChild($styleElement);
        }
        // Заменяем все \n
        $plaintText = preg_replace( "/\n\s+/", " ", rtrim(html_entity_decode(strip_tags($dom->saveHTML($content)))));
        // Разбиваем строку на слова атомы

        $words = preg_split("/[^а-яА-ЯA-Za-z0-9]/u", mb_convert_case($plaintText, MB_CASE_LOWER, "UTF-8"));
        // Убираем пустые строки и подсчитываем количество вхождений
        $wordCount = array_count_values(array_filter($words, static function ($value) { return trim($value) !== ''; }));
        return [$plaintText, $wordCount];
    }

    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        $articles = Article::all();
        return $articles;
    }

    public function search(string $word): \Illuminate\Support\Collection
    {
        $articles = DB::table('articles')
            ->join('words', 'articles.id', '=', 'words.article_id')
            ->where('word', 'like', $word)
            ->orderBy('count', 'DESC')
            ->get();
        return $articles;
    }
}
