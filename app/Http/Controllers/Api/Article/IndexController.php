<?php

namespace App\Http\Controllers\Api\Article;


use App\Http\Resources\Article\ArticleResource;

class IndexController extends ArticleController
{

    public function __invoke()
    {
        return ArticleResource::collection($this->articleService->index());
    }
}
