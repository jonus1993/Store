<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Orders;
use App\Cart_Items;
use App\Cart2;
use App\Order_Items;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller {

    protected $userid;

    public function __construct() {
        //parent::__construct();
        $this->middleware('auth');
//        $this->userid = auth()->id();
    }

//     public function __get($name) {
//        if (isset($this->data[$name]))
//    }


    public function saveOrder(Request $request) {

        $request->validate([
            'address' => 'required',
        ]);

        $this->userid = auth()->id();
        $Cart2 = new Cart2();
        $cartid = $Cart2->getCartId($this->userid);
        $cartid = $cartid->id;
        $totalQty = Cart_Items::where('cart_id', $cartid)->sum('qty');
        $totalPrice = Cart_Items::where('cart_id', $cartid)->with('item')->get();
//      dd($totalPrice);
        $totalPrc = 0;
        foreach ($totalPrice as $totPrc)
            $totalPrc += $totPrc['qty'] * $totPrc->item->price;

        //tworzenie zamówienia nowego
        $order = new Orders();
        $order->user_id = $this->userid;
        $order->address_id = $request->input('address');
        $order->total_items = $totalQty;
        $order->total_cost = $totalPrc;
        $order->save();

        //kopiowanie produktów z koszyka do zamówienia
        foreach ($totalPrice as $totPrc) {
            $orderItems = new Order_Items();
            $orderItems->order_id = $order->id;
            $orderItems->item_id = $totPrc->item->id;
            $orderItems->qty = $totPrc['qty'];
            $orderItems->save();
        }
        //usuwanie przedmiotów z koszyka w bazie
        //usuwanie koszyka z bazy
        $Cart2->delCart($cartid);




        return view('orders.finished', ['orderid' => $order->id]);
    }

    public function showOrders() {
        $this->userid = auth()->id();
        $orders = Orders::where('user_id', $this->userid)->get();
        return view('orders.allOrders', compact('orders'));
    }

    public function showOrder($orderId) {
//        $order = DB::table('order__items')->where('order_id', $orderId)->get();
         $order = Order_Items::where('order_id', $orderId)->with('item')->get();

        return view('orders.Order', compact('order'));
    }

}
