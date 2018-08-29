<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ghanem\Rating\Traits\Ratingable as Rating;
use Illuminate\Http\Request;
use App\Notifications\PriceDown;
use App\NotifiPrice;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\Builder;

//use Illuminate\Support\Facades\Validator;
//use App\Providers\ValidatorServiceProvider;

class Items extends Model
{
    use Rating;

    public function generateToken()
    {
        $this->api_token = str_random(60);
        $this->save();

        return $this->api_token;
    }

    public function saveItem($request, $itemID = null)
    {


//        $this->doValidation($request);
        $request->validated();


        $input = $request->all();

        if ($itemID == null) {
            $item = new Items();
        } else {
            $item = Items::where('id', '=', $itemID)->first();

            //wysłanie wiadomości dla subskryb <- jakoś tak antów
            //opóźnienie wiadomości należy dodać  ->delay($when));
            $when = now()->addMinutes(10);

            $item->fill($input);

            if ($input['price'] < $item->price) {
                $item->save();
                $users = NotifiPrice::where('item_id', $itemID)->with('item')->with('user')->get();
                foreach ($users as $user) {
                    $user->user->notify((new PriceDown($users[0]->item))->delay($when));
                }
            }
        }

        //dodawanie/zmienianie zdjęcia
        if (Input::has('photo_name')) {
            File::delete('photos/' . $item->photo_name);
            $item->photo_name = $this->addPhoto($request);
        }
        $item->save();

        //dodawanie tagów
        if (Input::has('tags')) {
            $item->tags()->sync($request->input('tags'));
        }
    }

    protected function addPhoto($request)
    {
//        $file = $request->file('photo_name');
//
//        // generate a new filename. getClientOriginalExtension() for the file extension
//        $filename = time() . '.' . $file->getClientOriginalExtension();
//
//        // save to storage/app/photos as the new $filename
//        $file->storeAs('photos', $filename);
//
//        return $filename;
        // get current time and append the upload file extension to it,
        // then put that name to $photoName variable.
        $photoName = time() . '.' . $request->file('photo_name')->getClientOriginalExtension();

        /*
          talk the select file and move it public directory and make avatars
          folder if doesn't exsit then give it that unique name.
         */
        $request->photo_name->move(public_path('photos'), $photoName);

        return $photoName;
    }

    protected function doValidation(Request $request)
    {

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
//      'price' => 'required|regex:/^[0-9.,]+$/',
            'price' => "required|regex:/^\d*(\.\d{1,2})?$/",
            'photo_name' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|numeric',
            array('tags' => 'nullable|numericarray'),
                //            'tags' => 'nullable|array',
//            'tags.*' => 'integer'
        ]);
    }

    protected $fillable = [
        'id', 'name', 'category_id', 'price', 'photo_name'
    ];

    public function tags()
    {
        return $this->belongsToMany(Tags::class, 'item_tags', 'item_id', 'tag_id')->withTimestamps();
    }

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('not_deleted', function ($builder) {
            $builder->where('is_deleted', '<>', 1);
        });
    }
}
