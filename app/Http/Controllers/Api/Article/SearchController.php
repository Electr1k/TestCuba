<?php

namespace App\Http\Controllers\Api\Article;


use App\Http\Resources\Article\ArticlesWrapperResource;
use Illuminate\Http\Request;


/**
 * Однометодный контроллер для поиска по ключевому слову в статьях
 */
class SearchController extends ArticleController
{

    public function __invoke(Request $request): array
    {
        $word = $request->validate(['word' => 'required|string|max:255|min:1'])['word'];
        $wrapper = new ArticlesWrapperResource($this->articleService->search($word));
        return $wrapper->resolve();
    }
}
