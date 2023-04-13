<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
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
            'startTime' => 'required|date',
            'endTime'   => 'required|date',
            'floorId'   => 'required|numeric'
        ];
    }

    public function messages(){
        return [
            'startTime.required' => 'Thời gian bắt đầu không để trống',
            'startTime.date'     => 'Thời gian bắt đầu không không đúng định dạng',
            'endTime.required'   => 'Thời gian kết thúc không để trống',
            'endTime.date'       => 'Thời gian kết thúc không đúng định dạng',
            'floorId.required'   => 'Yêu cầu chọn số tầng cần tìm',
            'floorId.numeric'    => 'Số tầng đã chọn không hợp lệ'
        ];
    }
}
