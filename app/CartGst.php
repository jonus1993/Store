<?php

namespace App;

class CartGst
{
    //dla niezalogowanego
    
    public $items = null;
    public $totalQty = 0;
    public $totalPrice = 0;

    public function __construct($oldCart)
    {
        if ($oldCart) {
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
        }
    }

    public function add($item, $id, $qty = 1)
    {
        $storedItem = ['qty' => 0, 'price' => $item->price, 'item' => $item];
        if ($this->items) {
            if (array_key_exists($id, $this->items)) {
                $storedItem = $this->items[$id];
            }
        }
        $storedItem['qty'] += $qty;
        $storedItem['price'] = $item->price * $storedItem['qty'];
        $this->items[$id] = $storedItem;
        $this->totalQty += $qty;
        $this->totalPrice += $item->price * $qty;
    }

    public function del(Items $item)
    {
        $id = $item->id;
        if ($this->items) {
            if (array_key_exists($id, $this->items)) {
                $storedItem = $this->items[$id];
            }
            $this->totalPrice -= $item->price * $storedItem['qty'];
            $this->totalQty -= $storedItem['qty'];

            unset($this->items[$id]);
        }
    }
}
