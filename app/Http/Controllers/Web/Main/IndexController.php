<?php

namespace App\Http\Controllers\Web\Main;


use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller as BaseController;

/**
 * Однометодный контроллер для главной страницы
 */
class IndexController extends BaseController
{

    public function __invoke()
    {
        return view('main');
    }
}
