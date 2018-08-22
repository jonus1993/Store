<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Providers\ValidatorServiceProvider;
use App\Items;
use App\Tags;
use App\ItemTag;
use App\Categories;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Notifications\PriceDown;
use App\NotifiPrice;
use Illuminate\Support\Facades\Storage;

class ModeratorController extends Controller {

    public function __construct() {
        $this->middleware('auth');
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
        $this->doValidation($request);
        $input = $request->all();
        $item = new Items();
        //dodawanie zdjęcia
        if (Input::has('photo_name'))
            $item->photo_name = $this->addPhoto($request);
        $item->fill($input)->save();

        //dodawanie tagów
        if (Input::has('tags'))
            $this->addTags($request, $item->id);

        //dodawnia wiadomości po wykonanej akcji
        Session::flash('message', "Pomyślnie dodano kolorek");
        return redirect()->route('item.create');
    }

    public function editItem($itemid) {
        $tags = Tags::all();
        $categories = Categories::all();
        $item = Items::where('id', '=', $itemid)->with('category')->with('tags')->first();
        //dd($item);
        return view('items.edit', compact('tags', 'categories', 'item'));
    }

    public function updateItem(Request $request, $itemID) {
        $this->doValidation($request);

        $item = Items::where('id', '=', $itemID)->first();
        $input = $request->all();
//        dd($item->photo_name);
        //zmienianie zdjęcia
        if (Input::has('photo_name'))
//            Storage::delete('public/photos/' . $item->photo_name);
            $item->photo_name = $this->addPhoto($request);

        //wysłanie wiadomości dla subskryb <- jakoś tak antów 
        if ($input['price'] < $item->price) {
            $item->fill($input)->save();
            $users = NotifiPrice::where('item_id', $itemID)->with('item')->with('user')->get();
            foreach ($users as $user)
                $user->user->notify(new PriceDown($users[0]->item));
        } else {
            $item->fill($input)->save();
        }

        ItemTag::where('item_id', $itemID)->delete();
        if (Input::has('tags'))
            $this->addTags($request, $itemID);

        //dodawnia wiadomości po wykonanej akcji
        Session::flash('message', "Pomyślnie zedytowano kolorek");
        return redirect()->back();
    }

    protected function addTags(Request $request, $itemID) {

        $tags = $request->input('tags');
        foreach ($tags as $tagid) {
            $itemTag = new ItemTag();
            $itemTag->item_id = $itemID;
            $itemTag->tag_id = $tagid;
            $itemTag->save();
        }
    }

    protected function addPhoto(Request $request) {

//            $request->photo_name->move(public_path('photos'), $photoName);

        $file = $request->file('photo_name');

        // generate a new filename. getClientOriginalExtension() for the file extension
        $filename = time() . '.' . $file->getClientOriginalExtension();

        // save to storage/app/photos as the new $filename
        $file->storeAs('photos', $filename);

        return $filename;
    }

    protected function doValidation(Request $request) {

        //        Validator::extend('numericarray', function($attribute, $value, $parameters) {
//            if (is_array($value)) {
//                foreach ($value as $v) {
//                    if (!is_int($v))
//                        return false;
//                } return true;
//            } return is_int($value);
//        });

        $request->validate([
            'name' => 'bail|required|min:4|max:255|regex:/^[A-ZĄŻŹĘŚĆŁÓa-ząćłśóżźę0-9., \/]+$/',
            'price' => 'required|regex:/^[0-9., ]+$/',
            'photo_name' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|numeric',
            array('tags' => 'nullable|numericarray'),
        ]);


//         $request->validate([
//            'name' => 'bail|required|min:4|max:255|regex:/^[A-ZĄŻŹĘŚĆŁÓa-ząćłśóżźę0-9., \/]+$/',
//            'price' => 'required|regex:/^[0-9., ]+$/',
//            'photo_name' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//            'category_id' => 'required|numeric',
//            'tags' => 'nullable|array',
//            'tags.*' => 'integer'
//        ]);
    }

    public function deleteItem($itemID) {

        ItemTag::where('item_id', $itemID)->delete();
        Items::where('id', '=', $itemID)->delete();
        Session::flash('message', "Pomyślnie dodano");
        return redirect()->back();
    }

}
