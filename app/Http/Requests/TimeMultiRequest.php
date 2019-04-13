<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TimeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'staff_id.0'   => 'required',
            'staff_id.*'   => 'required_with:start_time.*',
            'start_time.0' => 'required',
            'start_time.*' => 'required_with:end_time.*',
            'end_time.0'   => 'required',
            'end_time.*'   => 'required_with:staff_id.*',
            'work_dt'      => 'required',
        ];
    }

    /**
     * エラーメッセージ用文言
     * @return array|mixed
     */
    public function attributes()
    {
        $postData['staff_id.*']   = 'スタッフ名';
        $postData['start_time.*'] = '勤務開始時刻';
        $postData['end_time.*']   = '勤務終了時刻';
        $postData['work_dt']    = '出勤日';

        return $postData;
    }
}
