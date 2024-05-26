<?php

namespace App\Http\Controllers\Api\Import;


use App\Http\Resources\Article\ArticleResource;

class IndexController extends ImportController
{

    public function __invoke()
    {
        return ArticleResource::collection($this->articleService->index());
    }
}
