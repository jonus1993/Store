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



Route::get('/checkout', [
    'uses' => 'ItemsController@getCheckout',
    'as' => 'checkout'
]);

Route::post('/checkout', [
    'uses' => 'ItemsController@postCheckout',
    'as' => 'checkout'
]);

Route::get('/checkout2', [
    'uses' => 'DatatablesController@getCheckout',
    'as' => 'checkout2'
]);



Route::prefix('address')->group(function () {
    Route::get('/', [
        'uses' => 'AddressController@index',
        'as' => 'address.add'
    ]);
    Route::post('/', [
        'uses' => 'AddressController@store',
        'as' => 'address.add'
    ]);
    Route::get('/edit/{id}', [
        'uses' => 'AddressController@edit',
        'as' => 'address.edit'
    ]);
    Route::post('/edit/{id}', [
        'uses' => 'AddressController@update',
        'as' => 'address.edit'
    ]);
    
    Route::delete('del/{id}', [
        'uses' => 'AddressController@delete',
        'as' => 'address.del'
    ]);
});




Route::get('/items2', 'DatatablesController@getIndex')->name('datatables');
Route::get('/items2/datatables.data', 'DatatablesController@anyData')->name('datatables.data');
Route::get('/items2/{item}/{qty?}', [
//    function($qty = 1) {
//        return $qty;
//    },
    'uses' => 'DatatablesController@getAddToCart',
    'as' => 'item2.addToCart',
        ]
);

Route::get('/cart2', 'DatatablesController@getCart')->name('goToCart2');

Route::get('/cart2/{id}', [
    'uses' => 'DatatablesController@delFromCart',
    'as' => 'item2.delFromCart'
]);

//Route::get('/items2', 'DatatablesController', [
//    'anyData' => 'datatables.data',
//    'getIndex' => 'datatables',
//]);


Route::get('/items3', 'DatatablesController@getItems')->name('get.items');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
