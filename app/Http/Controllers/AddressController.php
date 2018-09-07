<?php

namespace App\Http\Controllers;

use Exception;
use App\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

  

    public function index()
    {
        $addresses = new Address();

        return view('address.list')->with('addresses', $addresses->getAddresses());
    }
    
    public function show($id)
    {
        return redirect('/home');
    }
    
    
      public function create()
    {
        return view('address.index');
    }



    public function getErrors($errors)
    {
        return view('address.errors', ['errors' => $errors]);
    }

    public function store(Request $request)
    {
        $address = new Address();
        $address->store($request);

        Session::flash('message', "Pomyślnie dodano");
        return redirect($request->input('last_url', '/home'));
    }
    
    public function store2(Request $request)
    {
        $address = new Address();
        $address = $address->store($request);

//        try {
//            $address->store($request);
//        } catch (\Illuminate\Validation\ValidationException $ex) {
//            return response(view('home2')
//                ->with('errors', $ex->validator->errors()), 422);
//        }

      
        return view('Address.list_item', ['address' => $address]);
    }

  

    public function edit(Address $address)
    {
        $this->authorization($address);
           
        if (request()->expectsJson()) {
            return view('address.form2', compact('address'));
        }

        return view('address.edit', compact('address'));
    }

 

    public function update(Request $request, Address $address)
    {
        $this->authorization($address);
        $this->addressValidation($request);
        $input = $request->all();
        $address->fill($input)->save();
        if (request()->expectsJson()) {
            return view('Address.list_item', ['address' => $address]);
        }
        return redirect('/home');
    }

    public function destroy(Address $address)
    {
        $this->authorization($address);
        $address->delete();
        if (request()->expectsJson()) {
            return response('Address Deleted!');
        }
        return redirect('/home');
    }

    public function authorization(Address $address)
    {
        if ($address->user_id != auth()->id()) {
            return abort(403, 'Unauthorized action.');
        }
    }

    public function addressValidation(Request $request)
    {
        $request->validate([
            'street' => 'bail|required|min:4|max:255|regex:/^[A-ZĄŻŹĘŚĆŁÓa-ząćłśóżźę0-9., \/]+$/',
            'city' => 'required|min:2|max:128|regex:/^[A-ZĄŻŹĘŚĆŁÓa-ząćłśóżźę0-9.]+$/',
            'zip_code' => 'required|size:6|regex:[[0-9][0-9]-[0-9][0-9][0-9]]',
            'phone' => 'required|numeric',
        ]);
    }
}
