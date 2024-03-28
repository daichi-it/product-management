<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShippingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'address' => 'required|max:255',
            'tel' => 'required|string|regex:/^\d{2,4}-?\d{2,4}-?\d{4}$/',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => '出荷先名',
            'address' => '出荷先住所',
            'tel' => '出荷先電話番号',
        ];
    }
}