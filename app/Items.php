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
    
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['avgRating', 'countPositive'];

    public function generateToken()
    {
        $this->api_token = str_random(60);
        $this->save();

        return $this->api_token;
    }

    public function saveItem($request, Items $item = null)
    {
//        $this->doValidation($request);
//        $request->validated();
        $input = $request->all();

        if ($item == null) {
            $item = new Items();
        }
        $item->fill($input);
        //dodawanie/zmienianie zdjęcia
        if (Input::has('photo_name')) {
            File::delete('photos/' . $item->photo_name);
            $item->photo_name = $this->addPhoto($request);
        }
        
        $item->is_deleted = 0;
        $item->save();
           
        //wysłanie wiadomości dla subskryb <- jakoś tak antów
        //opóźnienie wiadomości należy dodać  ->delay($when));
        if ($input['price'] < $item->price) {
            $users = NotifiPrice::where('item_id', $item->id)->with('item')->with('user')->get();
            $when = now()->addMinutes(10);
            foreach ($users as $user) {
                $user->user->notify((new PriceDown($users[0]->item))->delay($when));
            }
        }
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
    
    public function cart()
    {
        return $this->belongsToMany(Cart::class, 'cart_items', 'item_id', 'cart_id')->withPivot('qty')->withTimestamps();
    }
    
     public function promo()
    {
        return $this->hasMany(Promo::class,'item_id');
    }
    
    public function rating() {
        return $this->hasMany('\Ghanem\Rating\Models\Rating','ratingable_id');
    }
    
    

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('not_deleted', function ($builder) {
            $builder->where('is_deleted', '<>', 1);
        });
    }
}
