<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GuestsOrders;
use Illuminate\Support\Facades\Session;
use App\Cart;
use App\GuestsOrders_Items;
use App\Validation\AddressValidator;

class GuestsOrdersController extends Controller
{
    public function postCheckout(Request $request)
    {
        if (!Session::has('cart')) {
            return view("cart.emptycart");
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        
        $validation = new AddressValidator();
        $validation->check($request);

 
        $order = new GuestsOrders();
        $order->fill($request->all());
        $order->total_items = $cart->totalQty;
        $order->total_cost = $cart->totalPrice;
        $order->save();

        foreach ($cart->items as $item) {
            $orderItems = new GuestsOrders_Items();
            $orderItems->order_id = $order->id;
            $orderItems->item_id = $item['item']['id'];
            $orderItems->qty = $item['qty'];
            $orderItems->save();
        }

        $request->session()->forget('cart');
        
        return view('orders.finished', ['orderid' => $order->id]);
    }
}
