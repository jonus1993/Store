<?php

// Main
Breadcrumbs::for('main', function ($trail) {
    $trail->push('Main', url('/'));
});

// Items
Breadcrumbs::for('items', function ($trail) {
        $trail->parent('main');
    $trail->push('Items', url('/item'));
});

// Item
Breadcrumbs::for('item', function ($trail,$item) {
        $trail->parent('items');
    $trail->push($item->name, route('item.show',$item->name));
});

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('home'));
});

// Home > Add address
Breadcrumbs::for('addAddress', function ($trail) {
    $trail->parent('home');
    $trail->push('Add address', route('address.index'));
});

// Home > Add address
Breadcrumbs::for('editAddress', function ($trail, $address) {
    $trail->parent('home');
    $trail->push('Edit address', route('address.edit', $address->id));
});