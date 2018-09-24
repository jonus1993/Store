<?php

namespace App\Http\Controllers;

use App\Items;
use App\Categories;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\ItemAddPost;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use Yajra\Datatables\Datatables;
use App\Tags;

class ItemsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:delete, App\User')->only('destroy');
        $this->middleware('can:moderator-allowed')->except('show', 'index','getItemsDT');
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
    
    public function index(Request $request)
    {
        if (!$request->has('tags') && !$request->has('categories')) {
            $items = Items::paginate(11);
        } else {
            $tagInput = $request->input('tags');
            $catInput = $request->input('categories');

            if ($tagInput === null) {
                $tagInput = Tags::select('friend_name')->get();
            }
            if ($catInput === null) {
                $catInput = Categories::select('id')->get();
            }
            $tagIds = Tags::select('id')->whereIn('friend_name', $tagInput)->get();
            $items = Items::whereIn('category_id', $catInput)
                    ->whereHas('tags', function ($q) use ($tagIds) {
                        $q->whereIn('tag_id', $tagIds);
                    })
                    ->paginate(11);
        }
        
        
  

        return view('items.index')->with('items', $items);
    }

    public function show(Items $item)
    {
        $avgrate = number_format($item->avgRating, 1);
        $allrates = $item->countPositive;

        return view('items.show', compact('item', 'avgrate', 'allrates'));
    }
    
    public function create()
    {
        return view('items.add2');
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
        return redirect()->route('item.add');
    }

    public function edit(Items $item)
    {
        return view('items.edit')->with('item', $item);
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
        Cart_Items::whereItem_id($item->id)->delete();
        ItemTag::whereItem_id($item->id)->delete();
        $item->is_deleted = 1;
        $item->save();
        
        Session::flash('message', trans("Pomyślnie usunięto"));
        return redirect()->back();
    }
    
         //funkcja dla DataTables, pobiera dane ajaxem
    public function getItemsDT()
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
    
   
}
