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

Route::get('/checkout',  [
    'uses' => 'ItemsController@getCheckout',
    'as' => 'checkout'
]);

Route::post('/checkout',  [
    'uses' => 'ItemsController@postCheckout',
    'as' => 'checkout'
]);

Route::get('/address',  [
    'uses' => 'AddressController@index',
    'as' => 'address.add'
]);
Route::post('/address', [
    'uses' => 'AddressController@store',
    'as' => 'address.add'
]);



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
