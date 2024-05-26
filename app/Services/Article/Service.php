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
        $response = $import->client->request('GET', $word);
        $html = $response->getBody()->getContents();
        $size = round(strlen($html)/(8*1024),1);
        $count_words = $this->parseHTML($html);
        DB::beginTransaction();
        try {
            $article = ['title' => $word, 'url' => env("WIKI_BASE_URL").$word, 'size' => $size];
            $article = Article::create($article);
            foreach ($count_words as $word => $count) {
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
            dd($e->getMessage());
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
        // Удаляем каждый элемент style
        while ($styleElement = $styleElements->item(0)) {
            $styleElement->parentNode->removeChild($styleElement);
        }
        // Удаляем теги и преобразуем в строку
        $content = strip_tags($dom->saveHTML($content));
        // Разбиваем строку на слова и подсчитываем количество вхождений
        return array_count_values(array_filter(
            \preg_split('/[\\s.,-«»]/u', $content, 0, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY),
            static function ($value) { return trim($value) !== ''; }
        ));
    }

    public function index(){
        $articles = Article::all();
        return $articles;
    }
}
