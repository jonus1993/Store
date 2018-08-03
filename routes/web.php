<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('/items', 'ItemsController@index');

Route::get('/items/{id}', [
    'uses' => 'ItemsController@getAddToCart',
    'as' => 'item.addToCart'
]);



Route::get('/cart', 'ItemsController@getCart');

Route::get('/cart2', 'DatatablesController@getCart')->name('goToCart2');

Route::get('/checkout', [
    'uses' => 'ItemsController@getCheckout',
    'as' => 'checkout'
]);

Route::post('/checkout', [
    'uses' => 'ItemsController@postCheckout',
    'as' => 'checkout'
]);

Route::get('/address', [
    'uses' => 'AddressController@index',
    'as' => 'address.add'
]);
Route::post('/address', [
    'uses' => 'AddressController@store',
    'as' => 'address.add'
]);


Route::get('/items2', 'DatatablesController@getIndex')->name('datatables');
Route::get('/items2/datatables.data', 'DatatablesController@anyData')->name('datatables.data');
Route::get('/items2/{item}', [
    'uses' => 'DatatablesController@getAddToCart',
    'as' => 'item2.addToCart'
]);
//Route::get('/items2', 'DatatablesController', [
//    'anyData' => 'datatables.data',
//    'getIndex' => 'datatables',
//]);


Route::get('/items3', 'DatatablesController@getItems')->name('get.items');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
