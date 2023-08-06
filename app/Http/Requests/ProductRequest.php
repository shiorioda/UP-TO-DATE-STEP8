<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'product_name' => 'required|max:20',
            'company_id' => 'required',
            'price' => 'required|min:0',
            'stock' => 'required|min:0',
        ];
    }

    public function attributes()
{
    return [
        'product_name' => '商品名',
        'price' => '価格',
        'stock' => '在庫数',
        'company_id' => 'メーカー名',
    
    ];
}

    public function messages() {
    return [
        'product_name.required' => ':attributeは必須項目です。',
        'price.required' => ':attributeは必須項目です。',
        'stock.required' => ':attributeは必須項目です。',
        'company_id.required' => ':attributeは必須項目です。',
        'price.required' => ':attributeは必須項目です。',
    ];
}
}
