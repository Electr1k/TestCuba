<?php

namespace App\Services\Article;

use App\Components\ImportWikiClient;
use App\Models\Article;
use App\Models\Word;
use DOMDocument;
use Illuminate\Support\Facades\DB;

class Service
{
    public function store(string $word): void
    {
        $import = new ImportWikiClient();
        $response = $import->client->request('GET', $word);
        $data = $response->getBody()->getContents();
        $dom = new DOMDocument();
        @$dom->loadHTML(mb_convert_encoding($data, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $divs = $dom->getElementById('bodyContent');

        $styleElements = $dom->getElementsByTagName('style');

        // Удаляем каждый элемент style
        while ($styleElement = $styleElements->item(0)) {
            $styleElement->parentNode->removeChild($styleElement);
        }

        $text = strip_tags($dom->saveHTML($divs));
        $count_words = array_count_values(array_filter(
            \preg_split('/[\\s.,-«»]/u', $text, 0, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY),
            static function ($value) { return trim($value) !== ''; }
        ));
        DB::beginTransaction();
        try {
            $article = ['title' => $word, 'url' => env("WIKI_BASE_URL").$word];
            $article = Article::create($article);
            foreach ($count_words as $word => $count) {
                Word::create([
                    'article_id' => $article->id,
                    'word' => $word,
                    'count' => $count
                    ]);
            }
            DB::commit();
        }
        catch (\Exception $e){
            DB::rollBack();
            dd($e->getMessage());
        }

    }
}
