<?php

namespace App\Http\Controllers;

use App\Address;
use App\User;
use Illuminate\Http\Request;

class AddressController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('address.index');
    }


    public function store(Request $request)
    {
        
     
        
        $request->validate([
            'street' => 'required|max:255',
            'city' => 'required',
            'zipcode' => 'required',
        ]);
          
        $address = new Address();
        $address->user_id = auth()->id();
        $address->street = $request->input('street');
        $address->city  = $request->input('city');
        $address->zip_code = $request->input('zipcode');
        $address->save();
        return redirect('/items');
    }

}
