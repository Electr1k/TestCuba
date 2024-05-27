<?php

namespace App\Http\Controllers\Api\Article;


use App\Http\Resources\Article\ArticleResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Однометодный контроллер для получения всех статей
 */
class IndexController extends ArticleController
{

    public function __invoke(): AnonymousResourceCollection
    {
        return ArticleResource::collection($this->articleService->index());
    }
}
