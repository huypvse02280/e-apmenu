<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditMacRequest extends FormRequest
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
            'mac_address'   => 'required|max:50',
            'user_no'   => 'numeric'
        ];
    }

    public function messages() 
    {
        return [
            'mac_address.required'  => 'データが必要です。',
            'mac_address.max'       => '50桁以内が必要です。',
            //'user_no.required'  => 'データが必要です。',
            'user_no.numeric'   =>  '数字が必要です。',
           
        ];
    }
}
