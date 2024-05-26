<?php

namespace App\Http\Controllers\Api\Article;


use App\Http\Resources\Article\ArticleResource;
use App\Http\Resources\Article\ArticleSearchResource;
use Illuminate\Http\Request;

class SearchController extends ArticleController
{

    public function __invoke(Request $request)
    {
        $word = $request->validate(['word' => 'required|string|max:255|min:1'])['word'];
        $word = $request->get('word');
        return ArticleSearchResource::collection($this->articleService->search($word));
    }
}
