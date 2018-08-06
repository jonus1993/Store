<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use App\Items;
use Illuminate\Http\Request;
use App\Cart2;
use App\Cart_Items;

class DatatablesController extends Controller {

    public function getIndex() {


        return view('items.index2');
    }

    public function anyData() {
        $items = Items::select(['id', 'name', 'price']);

//             ->limit(10)
//             ->get()->toArray();
//     
//     dd($items);
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

    public function getAddToCart(Items $item, $qty=1) {
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
            $cart_item->qty=$qty;
        }
        //jak jest to tylko zwiekszamy jego ilosc i zapisujemy w bazie
        $cart_item->qty+=$qty;
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
            return view("cart.emptycart");
        $cart_items = $this->checkCartEmpty($cart->id);
        if ($cart_items === null)
            return view("cart.emptycart");
        
//        dd($cart_items);
//        /* @var $cart_items \Illuminate\Database\Eloquent\Collection      */
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
        
        return view('cart.cart', compact('cart_items'));
    }
    
    public function delFromCart($id){
        
        Cart_Items::where('item_id', $id)->delete();
        return redirect('/cart2');
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

    public function getItems() {
        $itemas = DB::table('items')->get();

        return view('items.index3', ['items' => $itemas]);
    }

}
