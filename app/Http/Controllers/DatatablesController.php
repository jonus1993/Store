<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use App\Items;
use App\Cart2;
use App\Cart_Items;
use App\Tags;
use App\Categories;
use App\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Order_Items;
use App\GuestsOrders_Items;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class DatatablesController extends Controller
{
    protected $items;
    protected $cart;

    public function __construct()
    {
        $this->cart = new Cart2();
    }

    //funkcja dla DataTables, pobiera dane ajaxem
    public function anyData()
    {
        $catInput = Input::get('categories');
        $tagInput = Input::get('tags');

        $items = Items::with('category')
                ->with('tags');

        if ($catInput != null) {
            $items->whereIn('category_id', $catInput);
            
            //tworzenie ciasteczka dla kategorii, żeby pozaznaczać autmatycznie wybrane checkboxy
            setcookie('categories', "");
            $cookieCat = "";
            foreach ($catInput as $catIndex) {
                $cookieCat = $cookieCat.$catIndex . ',';
            }
            setcookie('categories', $cookieCat);
        }
        if ($tagInput != null) {
            $tagIds = Tags::select('id')->whereIn('friend_name', $tagInput)->get();
            $items->whereHas('tags', function ($q) use ($tagIds) {
                $q->whereIn('tag_id', $tagIds);
            });
        }


        return Datatables::of($items)->make();
    }

    //prywatna funkcja sprawdza czy user ma koszyk w bazie
    protected function checkCartExist($userID)
    {
        return Cart2::where('user_id', $userID)->first();
    }

    //prywatna funkcja sprawdza czy koszyk jest pusty
    protected function checkCartEmpty($cartID)
    {
        return Cart_Items::where('cart_id', $cartID)->with('item')->get();
    }

    public function getAddToCart(Items $item, $qty = 1)
    {
        // ściagamy cały obiek item dzięki odebranemu id
//        $item = Items::find($id);
        if ($item->is_delted == 1) {
            abort(403, 'Unauthorized action.');
        }

        $userID = auth()->id();

        //patrzymy czy user ma już koszyk w bazie
        // jak nie ma to tworzymy go
        $cart = Cart2::firstOrCreate(['user_id' => $userID]);

        //a teraz sprawdzamy czy juz mamy w koszyku przedmiot
        //jak nie ma to zaraz będzie
        $cart_item = Cart_Items::firstOrNew(['item_id' => $item->id, 'cart_id' => $cart->id]);
        $cart_item->qty += $qty;
        $cart_item->save();

        Session::flash('message', trans('messages.item2cart'));
        return redirect()->back();
    }

    public function getCart()
    {
        // id usera tak jakby z sesji
        $userID = auth()->id();
        //patrzymy czy user już koszyk ma w bazie
        $cart = $this->cart->getCartIns($userID);

        // jak nie ma to pustke zwracamy
        if ($cart === null) {
            return view('cart.emptycart');
        }
      
        $cart_items = $this->checkCartEmpty($cart->id);
        /* @var $cart_items \Illuminate\Database\Eloquent\Collection      */
        if ($cart_items->isEmpty()) {
            return view('cart.emptycart');
        }

        $totalQty = 0;
        $totalPrice = 0;

        foreach ($cart_items as $cart_item) {
            $qty = $cart_item->qty;
            $totalQty += $qty;
            $totalPrice += $cart_item->item->price * $qty;
        }

        return compact('cart_items', 'totalQty', 'totalPrice');
    }

    public function getCartView()
    {
        $cart = $this->getCart();
        if (!is_array($cart)) {
            return $cart;
        }

        return view('cart.cart', $cart);
    }

    //usuwanie przedmiotów z koszyka/koszyka
    public function delFromCart(Cart_Items $item)
    {
        $userID = auth()->id();
        $cart = $this->checkCartExist($userID);

        Cart_Items::where('cart_id', $cart->id)->where('id', $item->id)->delete();

        if (!Cart_Items::where('cart_id', $cart->id)->exists()) {
            $cart->delete();
        }


        return redirect()->route('goToCart2');
    }

    public function delCart()
    {
        $userID = auth()->id();
        $cart = $this->checkCartExist($userID);
        $cart->delete();

        return redirect()->route('goToCart2');
    }

    public function getCheckout()
    {
        $cart = $this->getCart();
        return view('cart.checkout', compact('cart'));
    }

    public function getOrderInfo(Request $request)
    {
        $itemID = $request->id;

        $guests = GuestsOrders_Items::where('item_id', $itemID)
                ->with('item');

        $orders = Order_Items::where('item_id', $itemID)
                        ->with('item')
                        ->union($guests)->get();


        return view('orders.table', compact('orders'));
    }
}
