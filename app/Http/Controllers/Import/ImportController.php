<?php

namespace App\Http\Controllers\Import;

use App\Services\Article\Service;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class ImportController extends BaseController
{
//    use AuthorizesRequests, ValidatesRequests;

    protected Service $articleService;
    public function __construct(Service $service)
    {
        $this->articleService = $service;
    }
}
