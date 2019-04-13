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
            'staff_id'     => 'required',
            'start_time.*' => 'required_with:end_time.*',
            'end_time.*'   => 'required_with:start_time.*',
            'work_dt.*'    => 'required:staff_id.*',
        ];
    }

    /**
     * エラーメッセージ用文言
     * @return array|mixed
     */
    public function attributes()
    {
        $postData['staff_id']   = 'スタッフ名';
        $postData['start_time.*'] = '勤務開始時刻';
        $postData['end_time.*']   = '勤務終了時刻';
        $postData['work_dt.*']    = '出勤日';
        return $postData;
    }
}
