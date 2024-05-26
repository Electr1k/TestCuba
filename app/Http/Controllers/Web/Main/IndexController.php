<?php

namespace App\Http\Controllers\Web\Main;


use Illuminate\Routing\Controller as BaseController;
use App\Models\Article;
use App\Services\Article\Service;

class IndexController extends BaseController
{

    public function __invoke()
    {
        return view('main');
    }
}
