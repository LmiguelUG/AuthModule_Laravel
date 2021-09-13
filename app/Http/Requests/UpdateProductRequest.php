<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;


class UpdateProductRequest extends FormRequest
{

    public function authorize() {
        return true;
    }

    public function rules()
    {
        return [
            // 'code'  => ['required','email', Rule::unique('products')->ignore($this->product->id, 'id')],
            'code'=>   'required|unique:products,code,'.$this->code.',code',
            'name'  => "required|min:3|max:50",
            'price' => 'required|numeric|min:1'
        ];
    }
}
