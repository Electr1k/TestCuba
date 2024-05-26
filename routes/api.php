<?php

use App\Http\Controllers\Api\Article\IndexController;
use App\Http\Controllers\Api\Article\SearchController;
use App\Http\Controllers\Api\Article\StoreController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/import', StoreController::class);
Route::get('/search', SearchController::class);
Route::get('/articles', IndexController::class);
