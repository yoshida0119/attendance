<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeptRequest extends FormRequest
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
            'dept_name' => 'required|unique:dept|max:255',
        ];
    }

    /**
     * エラーメッセージ用文言
     * @return array
     */
    public function attributes()
    {
        return [
            'dept_name' => '部署名',
        ];
    }
}
