<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('services')->group(function () {
    Route::apiResources([
        'articles' => 'ArticleController',
        'stores'   => 'StoreController'
    ]);
    Route::get('/articles/store/{id}','ArticleController@storeArticles');
});
