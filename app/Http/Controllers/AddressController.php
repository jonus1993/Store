<?php

namespace App\Http\Controllers;

use App\Address;
use App\User;
use Illuminate\Http\Request;

class AddressController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        return view('address.index');
    }

    public function store(Request $request) {

        $request->validate([
            'street' => 'bail|required|min:4|max:255|regex:/^[A-ZĄŻŹĘŚĆŁÓa-ząćłśóżźę0-9., \/]+$/',
            'city' => 'required|min:2|max:128|regex:/^[A-ZĄŻŹĘŚĆŁÓa-ząćłśóżźę0-9.]+$/',
            'zipcode' => 'required|size:6|regex:[[0-9][0-9]-[0-9][0-9][0-9]]',
            'phone' => 'required|numeric',
        ]);

        $address = new Address();
        $address->user_id = auth()->id();
        $address->street = $request->input('street');
        $address->city = $request->input('city');
        $address->zip_code = $request->input('zipcode');
        $address->phone = $request->input('phone');
        $address->save();
        return redirect('/home');
    }

    public function edit($addressid) {

        $address = Address::where('id', '=', $addressid)->first();
        return view('address.edit', compact('address'));
    }

    public function update(Request $request, $addressid) {

        $request->validate([
            'street' => 'bail|required|min:4|max:255|regex:/^[A-ZĄŻŹĘŚĆŁÓa-ząćłśóżźę0-9., \/]+$/',
            'city' => 'required|min:2|max:128|regex:/^[A-ZĄŻŹĘŚĆŁÓa-ząćłśóżźę0-9.]+$/',
            'zipcode' => 'required|size:6|regex:[[0-9][0-9]-[0-9][0-9][0-9]]',
            'phone' => 'required|numeric',
        ]);

        $address = Address::where('id', '=', $addressid)->first();
        $address->street = $request->input('street');
        $address->city = $request->input('city');
        $address->zip_code = $request->input('zipcode');
        $address->phone = $request->input('phone');
        $address->save();
        return redirect('/home');
    }

    public function delete($addressid) {

        Address::where('id', '=', $addressid)->delete();
        return redirect('/home');
    }

}
