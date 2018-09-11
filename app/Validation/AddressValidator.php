<?php

namespace App\Validation;

use Validator;
use Illuminate\Http\Request;

class AddressValidator
{
    public function check(Request $request)
    {
         Validator::make($request->all(), [
            'name' => 'bail|required|min:4|max:255|regex:/^[A-ZĄŻŹĘŚĆŁÓa-ząćłśóżźę., ]+$/',
            'street' => 'required|min:4|max:255|regex:/^[A-ZĄŻŹĘŚĆŁÓa-ząćłśóżźę0-9., \/]+$/',
            'city' => 'required|min:2|max:128|regex:/^[A-ZĄŻŹĘŚĆŁÓa-ząćłśóżźę0-9.]+$/',
            'zip_code' => 'required|size:6|regex:[[0-9][0-9]-[0-9][0-9][0-9]]',
            'phone' => 'required|numeric',
        ])->validate();

//        if ($validator->fails()) {
//            return redirect()->back()
//                        ->withErrors($validator)
//                        ->withInput();
//        }
    }
}
