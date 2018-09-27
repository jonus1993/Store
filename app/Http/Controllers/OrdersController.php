<?php

namespace App\Http\Controllers;

use App\Mail\OrderPlaced;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Orders;
use App\Address;
use Illuminate\Support\Facades\Session;
use App\CartGst;
use App\Cart;
use App\Validation\AddressValidator;
use App\Promo;

class OrdersController extends Controller
{
    public function saveOrder(Request $request)
    {
        $user = auth()->user();
        
        if ($request->has('address_id')) {
            $request->validate([
                'address_id' => 'required|numeric',
                
            ]);
            $addressID = $request->input('address_id');
        } else {
            $address = new Address();
            $addressID = $address->store($request);
        }
        
        if ($request->has('coupon')) {
            $request->validate([
                'coupon' => 'numeric',
            ]);
         
            $discount = Promo::find($request->input('coupon'));
        }
     
                
        $cart = $user->getCart();

        $cart_items = $cart->items()->get();

        $total_qty = 0;
        $total_cost = 0;
        
        foreach ($cart_items as $item) {
            $qty = $item->pivot->qty;
            $total_qty += $qty;
            $item_price = $item->price * $qty;
            if (isset($discount) && $item->id == $discount->item_id) {
                $total_cost += $item_price *((100-$discount->value)/100);
                $discount->used = 1;
                $discount->save();
            } else {
                $total_cost += $item->price * $qty;
            }
        }
     
        $cart->order()->attach([$user->id => ['address_id' => $addressID, 'total_cost' => $total_cost, 'total_qty' => $total_qty]]);

        $order = $user->orders()->orderBy('created_at', 'desc')->first();


        //wysyłanie wiadomości dla klienta
//        $orderM = Order_Items::where('order_id', $order->id)->with('item')->get();
//
//        Mail::to(auth()->user())
//                ->cc('jszwarc@merinosoft.com.pl')
//                ->send(new OrderPlaced($orderM));


        return view('orders.finished', ['orderid' => $order->id]);
    }
    
    
    public function saveGorder(Request $request)
    {
        if (!Session::has('cart')) {
            return view("cart.emptycart");
        }
        $oldCart = Session::get('cart');
        $cart = new CartGst($oldCart);
        
        $validation = new AddressValidator();
        $validation->check($request);
        
        $address = new Address();
        $address = $address->store($request);
        
        $cartDB =  Cart::create(['user_id' => 1, 'state' =>  0]);
        $cartDB->order()->attach([1 => ['address_id' => $address->id, 'total_cost' => $cart->totalPrice, 'total_qty' => $cart->totalQty]]);
               
       
        foreach ($cart->items as $item) {
            $cartDB->items()->attach([$item['item']->id => ['qty' => $item['qty']]]);
        }
        
        $request->session()->forget('cart');
        
        $order = Orders::whereCart_id($cartDB->id)->first();
        
        return view('orders.finished', ['orderid' => $order->id]);
    }

    public function showOrders()
    {
        $user = auth()->user();
        $orders = $user->orders()->get();
        return view('orders.allOrders', compact('orders'));
    }

    public function showOrder($orderID)
    {
        $user = auth()->user();
        $order = $user->orders()->whereId($orderID)->first()->cart()->first()->items()->get();
     
        return view('orders.Order', compact('order'));
    }
}
