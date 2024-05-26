<?php

namespace App\Http\Controllers\Api\Article;

use App\Services\Article\Service;
use Illuminate\Routing\Controller as BaseController;

abstract class ArticleController extends BaseController
{
//    use AuthorizesRequests, ValidatesRequests;

    protected Service $articleService;
    public function __construct(Service $service)
    {
        $this->articleService = $service;
    }
}
