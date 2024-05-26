<?php

namespace App\Http\Controllers\Api\Article;


use App\Http\Resources\Article\ArticlesWrapperResource;
use Illuminate\Http\Request;

class SearchController extends ArticleController
{

    public function __invoke(Request $request)
    {
        $word = $request->validate(['word' => 'required|string|max:255|min:1'])['word'];
        $word = $request->get('word');
        $wrapper = new ArticlesWrapperResource($this->articleService->search($word));
        return $wrapper->resolve();
    }
}
