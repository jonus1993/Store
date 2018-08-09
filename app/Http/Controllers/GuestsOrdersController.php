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
            return view("cart.index");
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        dd($cart);
        $request->validate([
            'who' => 'bail|required|min:4|max:255|regex:/^[A-ZĄŻŹĘŚĆŁÓa-ząćłśóżźę., ]+$/',
            'street' => 'required|min:4|max:255|regex:/^[A-ZĄŻŹĘŚĆŁÓa-ząćłśóżźę0-9., \/]+$/',
            'city' => 'required|min:2|max:128|regex:/^[A-ZĄŻŹĘŚĆŁÓa-ząćłśóżźę0-9.]+$/',
            'zipcode' => 'required|size:6|regex:[[0-9][0-9]-[0-9][0-9][0-9]]',
            'phone' => 'required|numeric',
        ]);
        
        $order = new GuestsOrders();
        $order->name = $request->input('who');
        $order->street = $request->input('street');
        $order->city = $request->input('city');
        $order->zip_code = $request->input('zipcode');
        $order->phone = $request->input('phone');
        $order->total_items = $cart->totalQty; 
        $order->total_cost = $cart->totalPrice; 
        $order->save();
        
        $orderItems = new GuestsOrders_Items();
        $orderItems->id = $order->id;
        $orderItems->item_id = $cart->items
          $orderItems->qty =      
        $orderItems ->save();
        

        
                return 1;
    }

}
