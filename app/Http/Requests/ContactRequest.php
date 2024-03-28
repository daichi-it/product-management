<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|string|email|max:255',
            'gender' => 'required|in:male,female',
            'tel' => 'required|string|regex:/^\d{2,4}-?\d{2,4}-?\d{4}$/',
        ];

        // 趣味 or 特技
        if ($this->input('gender') === 'male') {
            $rules['hobby'] = 'required'; // 男性: 趣味が必須
        } else {
            $rules['skill'] = 'required'; // 女性: 特技が必須
        }

        // 問い合わせ内容
        $rules['message'] = 'required';

        return $rules;
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => '名前',
            'email' => 'メールアドレス',
            'gender' => '性別',
            'tel' => '電話番号',
            'hobby' => '趣味',
            'skill' => '特技',
            'message' => '問い合わせ内容',
        ];
    }
}
