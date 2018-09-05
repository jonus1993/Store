<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\AddressController;

class Address extends Model {
    
    
       public function store(Request $request) {
        $validation = new AddressController();
        $validation->addressValidation($request);
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
        'street', 'zip_code', 'city', 'phone'
    ];
    protected $hidden = [
        'user_id',
    ];
    protected $table = 'addresses';

 

}
