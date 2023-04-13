<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadXMLRequest extends FormRequest
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
            'xml_file' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'xml_file.required'     => 'データが必要です。',
            'xml_file.mimes'        => 'xmlファイルをご選びください。'
        ];
    }
}
