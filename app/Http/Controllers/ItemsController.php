<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ItemsController extends Controller
{

    public function index()
    {
        $items = Items::paginate(14);

        return view('items.index', compact('items'));
    }


    public function getAddToCart(Request $request, $id)
    {
        $item = Items::find($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($item, $item->id);

        $request->session()->put('cart', $cart);
        return redirect('/items');

    }

    public function getCart()
    {
        if (!Session::has('cart')){
            return view("cart.index");
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        return view('cart.index', ['items' => $cart->items, 'totalPrice' => $cart->totalPrice]);
    }

    public function getCheckout()
    {
        if (!Session::has('cart')){
            return view("cart.index");
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $total = $cart->totalPrice;
        return view('items.checkout', ['total' => $total]);
    }

}
