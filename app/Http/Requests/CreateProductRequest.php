<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'code'  => 'required|unique:products,code',
            'name'  => 'required|min:3|max:50',
            'price' => 'required|numeric|min:1'
        ];
    }
}
