<?php

namespace App\Http\Controllers\Import;


use Illuminate\Http\Request;

class StoreController extends ImportController
{

    public function __invoke(Request $request)
    {
        $word = $request->validate(['word' => 'required|string|max:255|min:1'])['word'];

        $this->articleService->store($word);
    }
}
