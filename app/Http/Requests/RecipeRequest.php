<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecipeRequest extends FormRequest
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
            'title' => 'required|max:30',
            'introduction' => 'required|max:200',
            'amount' => 'required|max:10'
        ];

    }

    public function attributes()
    {
        return [
            'title' => '料理名',
            'introduction' => '紹介文',
            'amount' => '分量(何人前)'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attributeを入力してください',
            'max' => ':attributeは :max文字以内で入力してください'
        ];
    }
}
