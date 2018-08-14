<?php

namespace App\Http\Controllers;

use App\Items;
use App\Tags;
use App\ItemTag;
use App\Categories;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class ModeratorController extends Controller {

    public function __construct() {
        $this->middleware('admin');
    }
    
      /**
     * Execute an action on the controller.
     *
     * @param  string  $method
      @param  array   $parameters
      @return \Symfony\Component\HttpFoundation\Response
     */
//    public function callAction($method, $parameters)
//    {
//        //sprawdzam czy użytkownik ma uprawnienia do zapisania konfiguracji
//        //$this->authorize('konfiguracja-save');
//        if (!\Auth::user()->isAdmin()) {
//            return redirect(route('home'))->with('error', trans('messages.access_denied'));
//        }
//
//        return parent::callAction($method, $parameters);
//    }

    public function createNewItem() {
        
        
        $tags = Tags::all();
        $categories = Categories::all();
        return view('items.add', compact('tags', 'categories'));
    }

    public function saveNewItem(Request $request) {
        
        
        $request->validate([
            'name' => 'bail|required|min:4|max:255|regex:/^[A-ZĄŻŹĘŚĆŁÓa-ząćłśóżźę0-9., \/]+$/',
            'price' => 'required|regex:/^[0-9., ]+$/',
        ]);

        $item = new Items();
        $item->name = $request->input('name');
        $item->price = floatval($request->input('price'));
        $item->category_id = $request->input('category');
        $item->save();

        $tags = $request->input('tags');
        foreach ($tags as $tagid) {
            $itemTag = new ItemTag();
            $itemTag->item_id = $item->id;
            $itemTag->tag_id = $tagid;
            $itemTag->save();
        }

        return redirect('/item/new');
    }

    public function editItem($addressid) {

        $address = Address::where('id', '=', $addressid)->first();
        return view('address.edit', compact('address'));
    }

    public function updateItem(Request $request, $addressid) {

        $request->validate([
            'street' => 'bail|required|min:4|max:255|regex:/^[A-ZĄŻŹĘŚĆŁÓa-ząćłśóżźę0-9., \/]+$/',
            'city' => 'required|min:2|max:128|regex:/^[A-ZĄŻŹĘŚĆŁÓa-ząćłśóżźę0-9.]+$/',
            'zipcode' => 'required|size:6|regex:[[0-9][0-9]-[0-9][0-9][0-9]]',
            'phone' => 'required|numeric',
        ]);

        $address = Address::where('id', '=', $addressid)->first();
        $address->street = $request->input('street');
        $address->city = $request->input('city');
        $address->zip_code = $request->input('zipcode');
        $address->phone = $request->input('phone');
        $address->save();
        return redirect('/home');
    }

    public function delete($addressid) {

        Address::where('id', '=', $addressid)->delete();
        return redirect('/home');
    }

}
