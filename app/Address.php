<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Validation\AddressValidator;


class Address extends Model {
    
    
       public function store(Request $request) {
        $validation = new AddressValidator();
        $validation->check($request);
        $input = $request->all();
        $address = new Address();
        $address->user_id = auth()->id();
        $address->fill($input)->save();
        return $address;
    }
    
      public function getAddresses() {
        $userid = auth()->id();
        return Address::where('user_id',  $userid)->get();
    }

    protected $fillable = [
        'street', 'name', 'zip_code', 'city', 'phone'
    ];
    protected $hidden = [
        'user_id',
    ];
    protected $table = 'addresses';

 

}
