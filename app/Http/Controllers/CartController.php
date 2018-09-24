<?php

namespace App\Http\Controllers;

use App\Items;


use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function getCartView()
    {
        $cart = $this->getCart();
        if (!is_array($cart)) {
            return $cart;
        }

        return view('cart.cart', $cart);
    }
    
    public function getAddToCart(Items $item, $qty = 1)
    {
        if ($item->is_delted == 1) {
            abort(403, 'Unauthorized action.');
        }
        
        //patrzymy czy user ma już koszyk w bazie, jak nie ma to tworzymy go
        $cart = $this->getExCart();

        //a teraz sprawdzamy czy juz mamy w koszyku przedmiot
        $cart_item = $cart->items()->find($item->id);
        
        if ($cart_item === null) {
            $cart->items()->attach([$item->id => ['qty' => $qty]]);
        } else {
            $qty += $cart_item->pivot->qty;
            $cart->items()->updateExistingPivot($item->id, ['qty' => $qty]);
        }
       
        Session::flash('message', trans('messages.item2cart'));
        return redirect()->back();
    }

    //usuwanie przedmiotów z koszyka/koszyka
    public function delFromCart(Items $item)
    {
        $cart = $this->getExCart();
        $cart->items()->detach($item->id);
        
        return redirect()->route('goToCart2');
    }
    
    public function delCart()
    {
        $cart = $this->getExCart();
        $cart->items()->detach();
        
        return redirect()->route('goToCart2');
    }
    
    public function getCheckout()
    {
        $cart = $this->getCart();
//        dd($cart);
        return view('cart.checkout', compact('cart'));
    }
    


    public function getCart()
    {
        $cart = $this->getExCart();

        // jak nie ma to pustke zwracamy
        if ($cart === null) {
            return view('cart.emptycart');
        }
      
//        $cart_items = $this->checkCartEmpty($cart->id);
        $cart_items = $cart->items()->get();
//        dd($cart_items);
        /* @var $cart_items \Illuminate\Database\Eloquent\Collection      */
        if ($cart_items->isEmpty()) {
            return view('cart.emptycart');
        }

        $totalQty = 0;
        $totalPrice = 0;

        $promos = array();
        $user = auth()->user();
        foreach ($cart_items as $item) {
            $qty = $item->pivot->qty;
            $totalQty += $qty;
            $totalPrice += $item->price * $qty;
            if ($item->promo()->first() != null) {
                $promo = $user->promo()->whereItem_id($item->id)->first();
                if ($promo != null) {
                    array_push($promos, $promo);
                }
            }
        }

        return compact('cart_items', 'totalQty', 'totalPrice', 'promos');
    }
    
    protected function getExCart()
    {
        $user = auth()->user();
        return $user->getCart();
    }
}
