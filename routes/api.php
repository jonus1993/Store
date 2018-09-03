<?php

use Illuminate\Http\Request;
use App\Items;
use App\Http\Resources\Item as ItemRes;
use App\Http\Resources\ItemCollection as ItemCol;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('articles')->group(function () {
    Route::get('/', 'ArticleController@index');
    Route::get('/{article}', 'ArticleController@show');
    Route::post('/', 'ArticleController@store');
    Route::put('/{article}', 'ArticleController@update');
    Route::delete('/{article}', 'ArticleController@delete');
});



Route::get('itemsC', function () {
    return new ItemCol(Items::all());
});

Route::get('items/{id}', function ($id) {
    return new ItemRes(Items::where('id', $id)->first());
});

Route::get('items', function () {
    return ItemRes::collection(Items::all());
});
