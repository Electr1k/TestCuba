<?php

namespace App\Http\Controllers\Api\Article;


use App\Http\Resources\Article\ArticleResource;
use Illuminate\Http\Request;

class StoreController extends ArticleController
{

    public function __invoke(Request $request)
    {
        $word = $request->validate(['word' => 'required|string|max:255|min:1'])['word'];
        $article = $this->articleService->store($word);
        if ($article) return new ArticleResource($article);
        else return response('error', 400);
    }
}
