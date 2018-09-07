<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemAddPost extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'name' => 'bail|required|min:4|max:255|regex:/^[A-ZĄŻŹĘŚĆŁÓa-ząćłśóżźę0-9., \/]+$/',
            'price' => "required|regex:/^\d*(\.\d{1,2})?$/",
            'photo_name' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|nullable',
            'category_id' => 'required|numeric',
            array('tags' => 'nullable|numericarray'),
        ];
    }

}
