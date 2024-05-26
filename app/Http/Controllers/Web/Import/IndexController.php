<?php

namespace App\Http\Controllers\Web\Import;


use App\Http\Resources\Article\ArticleResource;
use App\Models\Article;

class IndexController extends ImportController
{

    public function __invoke()
    {
        $articles = Article::all();
        return view('main', $this->articleService->index(), compact('articles'));
    }
}
