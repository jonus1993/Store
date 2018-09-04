<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Items;
use App\Tags;
use App\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ItemsController extends Controller {

    public function index() {

        $items = Items::paginate(11);
        $tags = Tags::all();
        $categories = Categories::all();
        return view('items.index', compact('items', 'tags', 'categories'));
    }

    public function postIndex(Request $request) {

        $tags = Tags::all();
        $categories = Categories::all();

        if (!$request->has('tags') && !$request->has('categories')) {

            $items = Items::paginate(11);
        } else {
            $tagInput = $request->input('tags');
            $catInput = $request->input('categories');

            if ($tagInput === null)
                $tagInput = Tags::select('friend_name')->get();
            if ($catInput === null)
                $catInput = Categories::select('id')->get();


            $tagIds = Tags::select('id')->whereIn('friend_name', $tagInput)->get();
            $items = Items::whereIn('category_id', $catInput)
                    ->whereHas('tags', function ($q) use($tagIds) {
                        $q->whereIn('tag_id', $tagIds);
                    })
                    ->paginate(11);
        }

        return view('items.index', compact('items', 'tags', 'categories'));
    }

    public function getAddToCart(Request $request, Items $item, $qty = 1) {

        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($item, $item->id, $qty);
        $request->session()->put('cart', $cart);

        return redirect()->back();
    }

    public function delFromCart(Request $request, Items $item) {

        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->del($item);

        if ($cart->totalQty == 0)
            Session::forget('cart');
        else {
            $request->session()->put('cart', $cart);
        }

        return redirect()->back();
    }

    public function getCart() {

        if (!Session::has('cart')) {
            return view("cart.index");
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        return view('cart.index', ['items' => $cart->items, 'totalQty' => $cart->totalQty, 'totalPrice' => $cart->totalPrice]);
    }

    public function getCheckout() {

        if (!Session::has('cart')) {
            return view("cart.index");
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $total = $cart->totalPrice;

        return view('items.checkout', ['total' => $total]);
    }

    public function getItem(Items $itemID) {
        $item = $itemID;

        $avgrate = number_format($item->avgRating, 1);
        $allrates = $item->countPositive;



        return view('items.show', compact('item', 'avgrate', 'allrates'));
    }

}
