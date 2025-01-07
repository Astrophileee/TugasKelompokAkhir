<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.qty' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'total_price' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'products.required' => 'Keranjang belanja tidak boleh kosong.',
            'products.*.id.required' => 'ID produk wajib diisi.',
            'products.*.id.exists' => 'ID produk tidak valid.',
            'products.*.qty.required' => 'Kuantitas produk wajib diisi.',
            'products.*.qty.integer' => 'Kuantitas produk harus berupa angka.',
            'products.*.price.required' => 'Harga produk wajib diisi.',
            'total_price.required' => 'Total harga wajib diisi.',
            'total_price.numeric' => 'Total harga harus berupa angka.',
        ];
    }
    
    protected function prepareForValidation()
    {
        if ($this->has('products') && is_string($this->products)) {
            $this->merge([
                'products' => json_decode($this->products, true),
            ]);
        }
    }
}
