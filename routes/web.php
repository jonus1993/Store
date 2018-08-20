<?php

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('items')->group(function () {
    Route::get('/', 'ItemsController@index');
    Route::post('/', 'ItemsController@postIndex')->name('filter.data');

    Route::get('/{id}/{qty?}', [
        'uses' => 'ItemsController@getAddToCart',
        'as' => 'item.addToCart'
    ]);
});


Route::get('/item/{id}', [
    'uses' => 'ModeratorController@getItem',
    'as' => 'item.get'
]);

Route::group(['middleware' => 'can:moderator-allowed'], function () {

    Route::get('/new/', [
        'uses' => 'ModeratorController@createNewItem',
        'as' => 'item.create'
    ]);
    Route::post('/new', [
        'uses' => 'ModeratorController@saveNewItem',
        'as' => 'item.create'
    ]);

    Route::get('/edit/{id}', [
        'uses' => 'ModeratorController@editItem',
        'as' => 'item.edit'
    ]);
    Route::post('/edit/{id}', [
        'uses' => 'ModeratorController@updateItem',
        'as' => 'item.edit'
    ]);
});

Route::get('item/del/{id}', 'ModeratorController@deleteItem')->middleware('can:delete,App\User')->name('item.del');

Route::get('/cart', 'ItemsController@getCart');



Route::get('/checkout', [
    'uses' => 'ItemsController@getCheckout',
    'as' => 'checkout'
]);

Route::post('/checkout', [
    'uses' => 'GuestsOrdersController@postCheckout',
    'as' => 'checkout'
]);

Route::get('/checkout2', [
    'uses' => 'DatatablesController@getCheckout',
    'as' => 'checkout2'
]);

Route::post('/order', [
    'uses' => 'OrdersController@saveOrder',
    'as' => 'finishOrder'
]);

Route::get('/allorders', [
    'uses' => 'OrdersController@showOrders',
    'as' => 'allOrders'
]);
Route::get('/order/{orderid}', [
    'uses' => 'OrdersController@showOrder',
    'as' => 'showOrder'
]);


//grupa routingów z prefixem /address/
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

Route::prefix('manage')->group(function () {

    Route::get('/', 'ManageController@getUserslist')->name('manage');
    Route::get('/del/{id}', 'ManageController@deleteUser')->name('del.user');
    Route::get('/{id}/', 'ManageController@changeUser')->name('chg.user');
});
Route::get('/items2', 'DatatablesController@getIndex')->name('datatables');
Route::get('/items2/datatables.data/{category?}/{tags?}', 'DatatablesController@anyData')->name('datatables.data');
Route::get('/items2/{item}/{qty?}', [
    'uses' => 'DatatablesController@getAddToCart',
    'as' => 'item2.addToCart',
        ]
);

Route::get('/cart2', 'DatatablesController@getCartView')->name('goToCart2');

Route::get('/cart2/{id}', [
    'uses' => 'DatatablesController@delFromCart',
    'as' => 'item2.delFromCart'
]);


Route::auth();


//z automatu przy authc sie tworzą
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
