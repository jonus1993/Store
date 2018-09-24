<?php

namespace App\Http\Controllers;

use App\CartGst;
use App\Items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


//kontroler do obsługi koszyka w sesji

class GuestCartController extends Controller
{
    
    public function getAddToCart(Request $request, Items $item, $qty = 1)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new CartGst($oldCart);
        $cart->add($item, $item->id, $qty);
        $request->session()->put('cart', $cart);

        return redirect()->back();
    }

    public function delFromCart(Request $request, Items $item)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new CartGst($oldCart);
        $cart->del($item);

        if ($cart->totalQty == 0) {
            Session::forget('cart');
        } else {
            $request->session()->put('cart', $cart);
        }

        return redirect()->back();
    }

    public function getCart()
    {
        if (!Session::has('cart')) {
            return view("cart.index");
        }
        $oldCart = Session::get('cart');
        $cart = new CartGst($oldCart);

        return view('cart.index', ['items' => $cart->items, 'totalQty' => $cart->totalQty, 'totalPrice' => $cart->totalPrice]);
    }

    public function getCheckout()
    {
        if (!Session::has('cart')) {
            return view("cart.index");
        }
        $oldCart = Session::get('cart');
        $cart = new CartGst($oldCart);
        $total = $cart->totalPrice;

        return view('items.checkout', ['total' => $total]);
    }
    

    
}
