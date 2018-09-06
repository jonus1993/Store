<?php

use App\Tags;
use App\Categories;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/nbp', function () {
    return view('nbp');
});

Route::prefix('items')->group(function () {
    Route::get('/', 'ItemsController@index');
    Route::post('/', 'ItemsController@postIndex')->name('filter.data');
    Route::get('/{item}/{qty?}', [
        'uses' => 'ItemsController@getAddToCart',
        'as' => 'item.addToCart'
    ]);
});

Route::get('/dist/{item}', [
    'uses' => 'ItemsController@delFromCart',
    'as' => 'item.sesdelete'
]);

Route::get(
    '/distAll',
    function () {
        if (Session::has('cart')) {
            Session::forget('cart');
        }
        return view("cart.index");
    }
)->name('forgetCart');

Route::get('/show/{itemID}', [
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



Route::prefix('item')->middleware('can:moderator-allowed')->group(function () {
    Route::get('/new/', [
        'uses' => 'ModeratorController@createNewItem',
        'as' => 'item.create'
    ]);
    Route::post('/new', [
        'uses' => 'ModeratorController@saveNewItem',
        'as' => 'item.create'
    ]);

    Route::get('/edit/{item}', [
        'uses' => 'ModeratorController@editItem',
        'as' => 'item.edit'
    ]);
    Route::post('/edit/{id}', [
        'uses' => 'ModeratorController@updateItem',
        'as' => 'item.edit'
    ]);
    Route::get('/del/{item}', 'ModeratorController@deleteItem')->name('item.del');
});




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
   
    Route::get('/edit/{address}', [
        'uses' => 'AddressController@edit',
        'as' => 'address.edit'
    ]);
    Route::post('/edit/{address}', [
        'uses' => 'AddressController@update',
        'as' => 'address.edit'
    ]);

    Route::delete('/del/{address}', [
        'uses' => 'AddressController@delete',
        'as' => 'address.del'
    ]);
});

Route::prefix('manage')->group(function () {
    Route::get('/', 'ManageController@getUserslist')->name('manage');
    Route::get('/del/{user}', 'ManageController@deleteUser')->name('del.user');
    Route::post('/cng', 'ManageController@changeUser')->name('chg.user');
});

Route::get('/orders/', 'ManageController@showAllorders')->name('manageOrders');



Route::get('/items2', function () {
    $tags = Tags::all();
    $categories = Categories::all();
    return view('items.index2', compact('tags', 'categories'));
})->name('datatables');

Route::get('/items3', function () {
    $tags = Tags::all();
    $categories = Categories::all();
    return view('items.index3', compact('tags', 'categories'));
})->name('datatables2');

Route::get('/items2/datatables.data/{category?}/{tags?}', 'DatatablesController@anyData')->name('datatables.data');
Route::get('/items2/order.info/', 'DatatablesController@getOrderInfo')->name('order.info');
Route::get(
        '/items2/{item}/{qty?}',
    [
    'uses' => 'DatatablesController@getAddToCart',
    'as' => 'item2.addToCart',
        ]
);

Route::get('/checkout2', [
    'uses' => 'DatatablesController@getCheckout',
    'as' => 'checkout2'
]);

Route::get('/cart', 'ItemsController@getCart')->name('goToCart');
Route::get('/cart2', 'DatatablesController@getCartView')->name('goToCart2');


Route::get('/cart2/del/{item}', [
    'uses' => 'DatatablesController@delFromCart',
    'as' => 'item2.delFromCart'
]);

Route::get('/cart2/delete', [
    'uses' => 'DatatablesController@delCart',
    'as' => 'delete.cart'
]);


Route::auth();

Route::fallback(function () {
    return "no chyba nie...";
});

//z automatu przy auth sie tworzą
Auth::routes();

Route::get('/home', 'HomeController')->name('home');

Route::prefix('/home2')->group(function () {
    Route::get('/', function () {
        return view('home2');
    })->name('home2');

    Route::get('/data', 'AddressController@getAddresses')->name('home2.data');
    Route::get('/form', function () {
        return view('address.form');
    })->name('home2.form');
            
    Route::post('/ajax/', [
        'uses' => 'AddressController@store2',
        'as' => 'address.add2'
    ]);
});
