<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
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
            'user_no'           => 'required',
            'username'          => 'required|max:100',
            'use_classify'      => 'required',
            'gender'            => 'required',
            'email'             => 'required|email',
            'cp_code'           => 'required',
            'team_id'           => 'required',
            'birthday'          => 'date',
            'phone'             => 'max:15',

        ];
    }

    public function messages() {
        return [
            'user_no.required'           => 'データが必要です。',
            'username.required'          => 'データが必要です。',
            //'username.min'               => '5桁以上が必要です。',
            'username.max'               => '100桁以内が必要です。',
            'use_classify.required'      => 'データが必要です。',
            'gender.required'            => 'データが必要です。',
            'email.required'             => 'データが必要です。',
            'email.email'                => '不正な形式です。',
            'cp_code.required'           => 'データが必要です。',
            'team_id.required'           => 'データが必要です。',
            'birthday.date'              => '不正な形式です。',
            //'phone.numeric'              => '不正な形式です。',
            'phone.max'                  => '15桁以内が必要です。'

        ];
    }
}
