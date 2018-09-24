<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Validation\AddressValidator;


class Address extends Model {
    
    
       public function store(Request $request, Address $address = null) {
        $validation = new AddressValidator();
        $validation->check($request);
        $input = $request->all();
        if($address == null)
             $address = new Address();
        $userID = auth()->id();
        if($userID == null)
            $userID = 1;       
        $address->user_id = $userID;
        $address->fill($input)->save();
        return $address;
    }
    
      public function getAddresses() {
        $userID = auth()->id();
        return Address::where('user_id',  $userID)->get();
    }

    protected $fillable = [
        'street', 'name', 'zip_code', 'city', 'phone'
    ];
    protected $hidden = [
        'user_id',
    ];
    protected $table = 'addresses';

 

}
