<?php

namespace App\Http\Controllers;

use App\Items;
use App\Tags;
use App\ItemTag;
use App\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\ItemAddPost;

class ModeratorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:delete, App\User')->only('destroy');
        $this->middleware('can:moderator-allowed')->except('show','index');
    }

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
    
      public function index()
    {
        $items = Items::paginate(11);
        $tags = Tags::all();
        $categories = Categories::all();
        return view('items.index', compact('items', 'tags', 'categories'));
    }

        public function show(Items $item)
    {
        $avgrate = number_format($item->avgRating, 1);
        $allrates = $item->countPositive;

        return view('items.show', compact('item', 'avgrate', 'allrates'));
    }
    
    public function create()
    {
        $tags = Tags::all();
        $categories = Categories::all();
        return view('items.add2', compact('tags', 'categories'));
    }

    public function store(ItemAddPost $request)
    {
        $item = new Items();
        $item->saveItem($request);
        
        if (request()->expectsJson()) {
            return null;
        }

        //dodawnia wiadomości po wykonanej akcji
        Session::flash('message', trans('messages.itemCreated'));
        return redirect()->route('item.create');
    }

    public function edit(Items $item)
    {
        $tags = Tags::all();
        $categories = Categories::all();
       
        return view('items.edit', compact('tags', 'categories', 'item'));
    }

    public function update(ItemAddPost $request, Items $item)
    {
        
        $item->saveItem($request, $item);

        //dodawnia wiadomości po wykonanej akcji
        Session::flash('message', trans('messages.itemEdited'));
        return redirect()->back();
    }

    public function destroy(Items $item)
    {
        ItemTag::where('item_id', $item->id)->delete();
        $item->is_deleted = 1;
        $item->save();
        Session::flash('message', trans("Pomyślnie usunięto"));
        return redirect()->back();
    }
}
