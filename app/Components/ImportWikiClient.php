<?php

namespace App\Components;

use GuzzleHttp\Client;

class ImportWikiClient
{
    public $client;
    public function __construct(){
        $this->client = new Client([
            'base_uri' => env('WIKI_API_BASE_URL'),
            'timeout'  => 2.0
        ]);
    }
}
