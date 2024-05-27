<?php

namespace App\Http\Controllers\Api\Article;

use App\Services\Article\Service;
use Illuminate\Routing\Controller as BaseController;


/**
 * Базовый контроллер для использования сервиса статей в наследниках
 */
abstract class ArticleController extends BaseController
{
    protected Service $articleService;
    public function __construct(Service $service)
    {
        $this->articleService = $service;
    }
}
