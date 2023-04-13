<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfigRequest extends FormRequest
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
            'c_key'     => 'required',
            'c_data'    => 'required',
            'c_help'    => 'required'
        ];
    }

    public function messages(){
        return [
            'c_key.required'    => 'データが必要です。',
            'c_data.required'   => 'データが必要です。',
            'c_help.required'   => 'データが必要です。'
        ];
    }
}
