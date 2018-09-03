<?php

namespace App\Http\Controllers;

use App\Items;
use App\Tags;
use App\ItemTag;
use App\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\ItemAddPost;

class ModeratorController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('can:delete, App\User')->only('deleteItem');
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

    public function saveNewItem(ItemAddPost $request) {
        
        $item = new Items();
        $item->saveItem($request);

        //dodawnia wiadomości po wykonanej akcji
        Session::flash('message', trans('messages.itemCreated'));
        return redirect()->route('item.create');
    }

    public function editItem($itemID) {
        
        $tags = Tags::all();
        $categories = Categories::all();
        $item = Items::where('id', '=', $itemID)->with('category')->with('tags')->first();

        return view('items.edit', compact('tags', 'categories', 'item'));
    }

    public function updateItem(ItemAddPost $request, $itemID) {
        
        $item = new Items();
        $item->saveItem($request, $itemID);

        //dodawnia wiadomości po wykonanej akcji
        Session::flash('message', trans('messages.itemEdited'));
        return redirect()->back();
    }

    public function deleteItem(Items $item) {
        
        ItemTag::where('item_id', $item->id)->delete();              
        $item->is_deleted = 1;
        $item->save();
        Session::flash('message', trans("Pomyślnie usunięto"));
        return redirect()->back();
    }

}
