<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'item_name' => 'required|string|max:255',
            'arrival_source' => 'required|string|max:255',
            'manufacturer' => 'required|string|max:255',
            'price' => 'required|integer',
            'email' => 'required|string|email|max:255',
            'tel' => 'required|string|regex:/^\d{2,4}-?\d{2,4}-?\d{4}$/'
        ];
    }
     
    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'item_name' => '商品名',
            'arrival_source' => '入荷元',
            'manufacturer' => '製造元',
            'price' => '価格',
            'email' => 'メールアドレス',
            'tel' => '電話番号',
        ];
    }
}
