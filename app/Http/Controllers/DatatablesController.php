<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use App\Items;
use App\Cart2;
use App\Cart_Items;
use App\Tags;
use App\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class DatatablesController extends Controller {

    protected $items;

    public function getIndex() {
        $tags = Tags::all();
        $categories = Categories::all();
        return view('items.index2', compact('tags', 'categories'));
    }

    public function anyData(Request $request) {

        $tagInput = $request->input('tags');
        $catInput = request()->input('categories');

        $tagInput = Tags::select('friend_name')->get();
        $catInput = Categories::select('id')->get();
        $catInput = Input::get('categories', $catInput);
        $tagInput = Input::get('tags', $tagInput);

        $tagIds = Tags::select('id')->whereIn('friend_name', $tagInput)->get();
        $items = Items::whereIn('category_id', $catInput)
                ->whereHas('tags', function ($q) use($tagIds) {
                    $q->whereIn('tag_id', $tagIds);
                })
                ->with('category')
                ->with('tags');
//        $items = Items::with('category')->with('tags');


        return Datatables::of($items)->make();
    }

    //prywatna funkcja sprawdza czy user ma koszyk w bazie
    protected function checkCartExist($userid) {

        return Cart2::where('user_id', '=', $userid)->first();
    }

    //prywatna funkcja sprawdza czy koszyk jest pusty
    protected function checkCartEmpty($cartid) {

        return Cart_Items::where('cart_id', '=', $cartid)->with('item')->get();
    }

    public function getAddToCart(Items $item, $qty = 1) {
//        return $qty;
        // ściagamy cały obiek item dzięki odebranemu id
//        $item = Items::find($id);
        // id usera tak jakby z sesji
        $userid = auth()->id();
        //patrzymy czy user już koszyk ma w bazie
        $cart = $this->checkCartExist($userid);
        // jak nie ma to tworzymy go
        if ($cart === null) {
            $cart = new Cart2;
            $cart->user_id = $userid;
            $cart->save();
        }

        //a teraz sprawdzamy czy juz mamy w koszyku przedmiot
        $cart_item = Cart_Items::where('item_id', '=', $item->id)->first();
        //jak nie ma to zaraz będzie
        if ($cart_item === null) {
            $cart_item = new Cart_Items;
            $cart_item->cart_id = $cart->id;
            $cart_item->item_id = $item->id;
//            $cart_item->qty=$qty;
        }
        //jak jest to tylko zwiekszamy jego ilosc i zapisujemy w bazie
        $cart_item->qty += $qty;
        $cart_item->save();

        return redirect('/items2');
    }

    public function getCart() {
        // id usera tak jakby z sesji
        $userid = auth()->id();
        //patrzymy czy user już koszyk ma w bazie
        $cart = $this->checkCartExist($userid);

        // jak nie ma to pustke zwracamy
        if ($cart === null)
            return view('cart.emptycart');
        $cart_items = $this->checkCartEmpty($cart->id);
        /* @var $cart_items \Illuminate\Database\Eloquent\Collection      */
        if ($cart_items->isEmpty())
            return view('cart.emptycart');


        $totalQty = 0;

        $totalPrice = 0;

        foreach ($cart_items as $cart_item) {
            $qty = $cart_item->qty;
            $totalQty += $qty;
            $totalPrice += $cart_item->item->price * $qty;
        }

        return compact('cart_items', 'totalQty', 'totalPrice');

//        dd($cart_items);
//        $itemIds = array();        
//        foreach ($cart_items as $cart_item) {
//            $itemIds[] = $cart_item->item_id;
//        }        
//        $itemsdt = Items::whereIn('id', $itemIds)->get();
//        
//        przykład odowołania do atrybutu po relacji
//        $cart_items[0]->item->price
        //$itemsdt = Items::whereIn('id', $cart_items->get('item_id'))->get();
//        return view('cart.cart', ['items' => $itemsdt]);
//         return view('cart.cart')->with('items', $itemsdt);
    }

    public function getCartView() {
//        dd($this->getCart());
        $cart = $this->getCart();
        if (!is_array($cart)) {
            return $cart;
        }

        return view('cart.cart', $cart);
    }

    //usuwanie przedmiotów z koszyka/koszyka
    public function delFromCart($id) {
        $userid = auth()->id();
        $cartid = Cart2::where('user_id', '=', $userid)->first();

        $cartid = $cartid->id;
        $Cart2 = new Cart2();
        //usuwanie całego koszyka
        if ($id == 0) {

//            Cart_Items::where('cart_id', $cartid)->delete();
//            Cart2::where('id', $cartid)->delete();

            $Cart2->delCart($cartid);
        } else {
            Cart_Items::where([['item_id', $id], ['cart_id', $cartid]])->delete();
            $cartEmpty = Cart_Items::where('cart_id', $cartid)->first();

            if (!$cartEmpty)
//                Cart2::where('id', $cartid)->delete();
                $Cart2->delCart($cartid);
        }


        return redirect()->route('goToCart2');
    }

    public function getCheckout() {

        $addresses = app('App\Http\Controllers\HomeController')->getAddresses();
//        $addresses = auth()->user()->addresses(); //?
//        dd($addresses);
        $cart = $this->getCart();
        if (!is_array($cart)) {
            return $cart;
        }

        return view('cart.checkout', compact('addresses', 'cart'));
    }

    public function getItems() {
        $itemas = DB::table('items')->get();

        return view('items.index3', ['items' => $itemas]);
    }

}
