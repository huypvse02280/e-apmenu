<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:abc,name',
            'address' => 'required'
        ];
    }

    public function messages(){
        return [
            'name.required' => 'Không để trống',
            'name.unique'   => 'Đã tồn tại',
            'address.required' =>'Không để trống'
        ];
    }
}
