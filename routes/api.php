<?php

use Illuminate\Http\Request;
use App\Items;
Use App\Http\Resources\Item as ItemRes;
Use App\Http\Resources\ItemCollection as ItemCol;
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

Route::get('articles', 'ArticleController@index');
Route::get('articles/{article}', 'ArticleController@show');
Route::post('articles', 'ArticleController@store');
Route::put('articles/{article}', 'ArticleController@update');
Route::delete('articles/{article}', 'ArticleController@delete');


Route::get('itemsC', function(){
    
    return new ItemCol(Items::all());
});

Route::get('items/{id}', function($id){
    
    return new ItemRes(Items::where('id',$id)->first());
});

Route::get('items', function(){
    
    return ItemRes::collection(Items::all());
});

