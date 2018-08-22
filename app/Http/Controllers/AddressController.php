<?php

namespace App\Http\Controllers;

use App\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AddressController extends Controller {

    protected $addressM;

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        return view('address.index');
    }

    public function store(Request $request) {
        $address = new Address();
        $address->store($request);
        Session::flash('message', "Pomyślnie dodano");
        return redirect($request->input('last_url', '/home'));
    }

    public function edit($addressID) {
        $this->authorization($addressID);
        $address = $this->addressM;
        return view('address.edit', compact('address'));
    }

    public function update(Request $request, $addressID) {
        $this->authorization($addressID);
        $this->addressValidation($request);
        $address = $this->addressM;
        $input = $request->all();
        $address->fill($input)->save();
        return redirect('/home');
    }

    public function delete($addressID) {
        $this->authorization($addressID);
        $this->addressM->delete();
        return redirect('/home');
    }

    public function authorization($addressID) {
        $address = $this->addressM = Address::where('id', '=', $addressID)->first();
        if ($address->user_id != auth()->id())
            return abort(403, 'Unauthorized action.');
    }

    public function addressValidation(Request $request) {
        $request->validate([
            'street' => 'bail|required|min:4|max:255|regex:/^[A-ZĄŻŹĘŚĆŁÓa-ząćłśóżźę0-9., \/]+$/',
            'city' => 'required|min:2|max:128|regex:/^[A-ZĄŻŹĘŚĆŁÓa-ząćłśóżźę0-9.]+$/',
            'zip_code' => 'required|size:6|regex:[[0-9][0-9]-[0-9][0-9][0-9]]',
            'phone' => 'required|numeric',
        ]);
    }

}
