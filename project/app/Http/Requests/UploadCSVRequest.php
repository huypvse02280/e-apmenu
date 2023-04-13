<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadCSVRequest extends FormRequest
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
            'csv_file'  => 'required'
        ];
    }

    public function messages()
    {
        return [
            'csv_file.required'     => 'データが必要です。',
            //'csv.mimes'             => 'csvファイルをご選びください。'
        ];
    }
}
