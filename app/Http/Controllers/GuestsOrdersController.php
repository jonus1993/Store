<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GuestsOrders;
use Illuminate\Support\Facades\Session;
use App\Cart;
use App\Items;
use App\GuestsOrders_Items;

class GuestsOrdersController extends Controller {

    public function postCheckout(Request $request) {

        if (!Session::has('cart')) {
            return view("cart.emptycart");
        }
//        return response(print_r(session()->all(), true), 200, [ 'Content-type' => 'text/plain' ]);
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        $request->validate([
            'name' => 'bail|required|min:4|max:255|regex:/^[A-ZĄŻŹĘŚĆŁÓa-ząćłśóżźę., ]+$/',
            'street' => 'required|min:4|max:255|regex:/^[A-ZĄŻŹĘŚĆŁÓa-ząćłśóżźę0-9., \/]+$/',
            'city' => 'required|min:2|max:128|regex:/^[A-ZĄŻŹĘŚĆŁÓa-ząćłśóżźę0-9.]+$/',
            'zip_code' => 'required|size:6|regex:[[0-9][0-9]-[0-9][0-9][0-9]]',
            'phone' => 'required|numeric',
        ]);
        
 

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
