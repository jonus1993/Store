<?php

Route::prefix('cart')->group(function () {
    Route::get('item/add/{item}/{qty?}', 'GuestCartController@getAddToCart')->name('item.addToCart');
    Route::get('item/dist/{item}', 'GuestCartController@delFromCart')->name('item.sesdelete');
    Route::get('/get', 'GuestCartController@getCart')->name('goToCart');
    Route::get('/item/distAll', function () {
        if (Session::has('cart')) {
            Session::forget('cart');
        }
        return view("cart.index");
    })->name('forgetCart');

    Route::get('/checkout', 'GuestCartController@getCheckout')->name('checkout');
    Route::post('/checkout', [
    'uses' => 'OrdersController@saveGorder',
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

Route::get('/order/{orderid}/', [
    'uses' => 'OrdersController@showOrder',
    'as' => 'showOrderU'
]);

Route::prefix('manage')->group(function () {
    Route::get('/', 'ManageController@getUserslist')->name('manage');
    Route::get('/del/{user}', 'ManageController@deleteUser')->name('del.user');
    Route::post('/cng', 'ManageController@changeUser')->name('chg.user');
    Route::get('/orders/', 'ManageController@showAllorders')->name('manageOrders');
    Route::get('/orders/{order}', 'ManageController@showOrder')->name('showOrderA');
    Route::get('/order/', 'ManageController@getOrderInfo')->name('order.info');
});





Route::middleware('can:moderator-allowed')->get('/moderator', function () {
    return view('items.moderator');
})->name('moderator.panel');



Route::get('/items2/{item}/{qty?}', [
    'uses' => 'CartController@getAddToCart',
    'as' => 'item2.addToCart',
        ]
);

Route::prefix('/cart2')->group(function () {
    Route::get('/checkout', [
    'uses' => 'CartController@getCheckout',
    'as' => 'checkout2'
]);
    Route::get('/get', 'CartController@getCartView')->name('goToCart2');
    Route::get('/del/{item}', [
    'uses' => 'CartController@delFromCart',
    'as' => 'item2.delFromCart'
]);
    Route::get('destroy', [
    'uses' => 'CartController@delCart',
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

Route::get('/test', function () {
    return view('test');
});

Route::get('/itemes/datatables.data', 'ItemsController@getItemsDT')->name('datatables.data');

Route::get('/itemes/datatables', function () {
    return view('items.index2');
})->name('datatables');

Route::get('/itemes/datatables2', function () {
    return view('items.index3');
})->name('item.datatables');

Route::get('/itemes/add', function () {
    return view('items.add');
})->name('item.add');

Route::resource('item', 'ItemsController');

Route::get('/promos/{id}', 'PromoController@restore')->name('promo.restore');

Route::resource('promo', 'PromoController');
Route::resource('address', 'AddressController');
