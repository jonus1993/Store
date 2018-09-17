<?php

Route::prefix('cart')->group(function () {
    Route::get('item/add/{item}/{qty?}', 'CartController@getAddToCart')->name('item.addToCart');
    Route::get('item/dist/{item}', 'CartController@delFromCart')->name('item.sesdelete');
    Route::get('/get', 'CartController@getCart')->name('goToCart');
    Route::get('/item/distAll', function () {
        if (Session::has('cart')) {
            Session::forget('cart');
        }
        return view("cart.index");
    })->name('forgetCart');

    Route::get('/checkout', 'CartController@getCheckout')->name('checkout');
    Route::post('/checkout', [
    'uses' => 'GuestsOrdersController@postCheckout',
    'as' => 'checkout'
]);
});

Route::get('/notifi/{id}', [
    'uses' => 'RatingController@saveNotfication',
    'as' => 'notifi.save'
]);

Route::get('/add_rate/{item}/{rate}', [
    'uses' => 'RatingController@addRate',
    'as' => 'add.rate'
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

Route::prefix('manage')->group(function () {
    Route::get('/', 'ManageController@getUserslist')->name('manage');
    Route::get('/del/{user}', 'ManageController@deleteUser')->name('del.user');
    Route::post('/cng', 'ManageController@changeUser')->name('chg.user');
});

Route::get('/orders/', 'ManageController@showAllorders')->name('manageOrders');

Route::get('/items2', function () {
    return view('items.index2');
})->name('datatables');

Route::get('/items3', function () {
    return view('items.index3');
})->name('datatables2');

Route::middleware('can:moderator-allowed')->get('/moderator', function () {
    return view('items.moderator');
})->name('moderator.panel');

Route::get('/items2/datatables.data/{category?}/{tags?}', 'DatatablesController@anyData')->name('datatables.data');
Route::get('/items2/order.info/', 'DatatablesController@getOrderInfo')->name('order.info');
Route::get(
        '/items2/{item}/{qty?}',
    [
    'uses' => 'DatatablesController@getAddToCart',
    'as' => 'item2.addToCart',
        ]
);

Route::prefix('/cart2')->group(function () {
    Route::get('/checkout', [
    'uses' => 'DatatablesController@getCheckout',
    'as' => 'checkout2'
]);

    Route::get('/get', 'DatatablesController@getCartView')->name('goToCart2');


    Route::get('/delete/{item}', [
    'uses' => 'DatatablesController@delFromCart',
    'as' => 'item2.delFromCart'
]);

    Route::get('deleteAll', [
    'uses' => 'DatatablesController@delCart',
    'as' => 'delete.cart'
]);
});


Route::get('/home', 'HomeController')->name('home');

Route::prefix('/home2')->group(function () {
    Route::get('/', function () {
        return view('home2');
    })->name('home2');

    Route::get('/form', function () {
        return view('address.form');
    })->name('home2.form');
            
    Route::post('/ajax/', [
        'uses' => 'AddressController@store2',
        'as' => 'address.add2'
    ]);
});


Route::auth();

Route::fallback(function () {
    return "no chyba nie...";
});

//z automatu przy auth sie tworzą
Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::get('/nbp', function () {
    return view('nbp');
});

Route::get('/nbp/VUEjs', function () {
    return view('nbpVUE');
});

Route::resource('item', 'ItemsController');
Route::resource('address', 'AddressController');
