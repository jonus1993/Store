<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('/nbp', function () {
    return view('nbp');
});

Route::prefix('items')->group(function () {
    Route::get('/', 'ItemsController@index');
    Route::post('/', 'ItemsController@postIndex')->name('filter.data');

    Route::get('/{id}/{qty?}', [
        'uses' => 'ItemsController@getAddToCart',
        'as' => 'item.addToCart'
    ]);
});


Route::get('/item/{itemID}', [
    'uses' => 'ItemsController@getItem',
    'as' => 'item.get'
]);



Route::get('/save_notifi/{id}', [
    'uses' => 'RatingController@saveNotfication',
    'as' => 'notifi.save'
]);

Route::get('/add_rate/{item}/{rate}', [
    'uses' => 'RatingController@addRate',
    'as' => 'add.rate'
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





Route::get('/checkout', [
    'uses' => 'ItemsController@getCheckout',
    'as' => 'checkout'
]);

Route::post('/checkout', [
    'uses' => 'GuestsOrdersController@postCheckout',
    'as' => 'checkout'
]);



Route::post('/order', [
    'uses' => 'OrdersController@saveOrder',
    'as' => 'finishOrder'
]);

Route::get('/allorders', [
    'uses' => 'OrdersController@showOrders',
    'as' => 'allOrders'
]);
Route::get('/order/{orderid}/{flag?}', [
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

Route::get('/orders/', 'ManageController@showAllorders')->name('manageOrders');


Route::get('/items2', 'DatatablesController@getIndex')->name('datatables');
Route::get('/items2/datatables.data/{category?}/{tags?}', 'DatatablesController@anyData')->name('datatables.data');
Route::get('/items2/order.info/', 'DatatablesController@getOrderInfo')->name('order.info');
Route::get('/items2/{item}/{qty?}', [
    'uses' => 'DatatablesController@getAddToCart',
    'as' => 'item2.addToCart',
        ]
);
Route::get('/checkout2', [
    'uses' => 'DatatablesController@getCheckout',
    'as' => 'checkout2'
]);


Route::get('/cart2', 'DatatablesController@getCartView')->name('goToCart2');
Route::get('/cart', 'ItemsController@getCart')->name('goToCart');

Route::get('/cart2/{id}', [
    'uses' => 'DatatablesController@delFromCart',
    'as' => 'item2.delFromCart'
]);


Route::auth();


//z automatu przy auth sie tworzą
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
