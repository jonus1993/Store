<?php

namespace App\Http\Controllers;

use App\Mail\OrderPlaced;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Orders;
use App\Cart_Items;
use App\Cart2;
use App\Order_Items;
use App\Address;
use App\GuestsOrders_Items;

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
        $this->userid = auth()->id();
        if ($request->has('address_id')) {
            $request->validate([
                'address_id' => 'required|numeric',
            ]);
            $addressID = $request->input('address_id');
        } else {

            $address = new Address();
            $addressID = $address->store($request);
        }

        $Cart2 = new Cart2();
        $cartID = $Cart2->getCartId($this->userid);

        $cartID = $cartID->id;

        $totalQty = Cart_Items::where('cart_id', $cartID)->sum('qty');
        $totalPrice = Cart_Items::where('cart_id', $cartID)->with('item')->get();
//      dd($totalPrice);
        $totalPrc = 0;
        foreach ($totalPrice as $totPrc)
            $totalPrc += $totPrc['qty'] * $totPrc->item->price;

        //tworzenie nowego zamówienia 
        $order = new Orders();
        $order->user_id = $this->userid;
        $order->address_id = $addressID;
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
        //wysyłanie wiadomości dla klienta
        $orderM = Order_Items::where('order_id', $order->id)->with('item')->get();

        Mail::to(auth()->user())
                ->cc('jszwarc@merinosoft.com.pl')
                ->send(new OrderPlaced($orderM));
        //usuwanie przedmiotów z koszyka w bazie
        //usuwanie koszyka z bazy
        $Cart2->delCart($cartID);
        return view('orders.finished', ['orderid' => $order->id]);
    }

    public function showOrders() {
        $this->userid = auth()->id();
        $orders = Orders::where('user_id', $this->userid)->get();
        return view('orders.allOrders', compact('orders'));
    }

    public function showOrder($orderId, $state = 1) {


        if ($state == 1) {
            $order = Orders::where('id', $orderId)->first();
            if ($order->user_id == auth()->id() || auth()->user()->isAdmin())
                $order = Order_Items::where('order_id', $orderId)->with('item')->get();
            else
                return abort(403, 'Unauthorized action.');
        } else {
            if (auth()->user()->isAdmin())
                $order = GuestsOrders_Items::where('order_id', $orderId)->with('item')->get();
            else
                return abort(403, 'Unauthorized action.');
        }

        return view('orders.Order', compact('order'));
    }

}
