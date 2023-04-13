<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditMapRequest extends FormRequest
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
            'map_name'           =>'required|min:5|max:100',
            'map_size_heigh'     => 'required|numeric',
            'map_size_width'     => 'required|numeric',
            'map_size_length'    => 'required|numeric',
            'image_name'         => 'image',
            'reserve_1'          => 'max:200',
            'reserve_2'          => 'max:200',
            'reserve_3'          => 'max:200'
        ];
    }

    public function messages(){
        return [
            'map_name.required'           => 'データが必要です。',
            'map_name.min'                => '5桁以上が必要です。',
            'map_name.max'                => '100桁以内が必要です。',
            'map_size_heigh.required'     => 'データが必要です。',
            'map_size_heigh.numeric'      => '数字が必要です。',
            'map_size_width.required'     => 'データが必要です。',
            'map_size_width.numeric'      => '数字が必要です。',
            'map_size_length.required'    => 'データが必要です。',
            'map_size_length.numeric'     => '数字が必要です。',
            'image_name.image'            => '不正な形式です。',
            'reserve_1.max'               => '200桁以内が必要です。',
            'reserve_2.max'               => '200桁以内が必要です。',
            'reserve_3.max'               => '200桁以内が必要です。'
        ];
    }
}
