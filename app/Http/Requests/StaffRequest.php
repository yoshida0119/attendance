<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
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
            'staff_name' => 'required|max:255',
            'dept_id'  => 'required',
        ];
    }

    /**
     * エラーメッセージ用文言
     * @return array
     */
    public function attributes()
    {
        return [
            'staff_name' => 'スタッフ名',
            'dept_id'  => '部署',
        ];
    }
}
