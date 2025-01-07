<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        $this->merge([
            'price' => str_replace(['Rp.', '.'], '', $this->price)
        ]);
    }
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
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer'],
            'stock' => ['required', 'integer'],
            'branch_id' => ['required', 'integer']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be a string.',
            'name.max' => 'Name must not exceed 255 characters.',

            'code.required' => 'Code is required.',
            'code.string' => 'Code must be a string.',
            'code.max' => 'Code must not exceed 255 characters.',

            'price.required' => 'Price is required.',
            'price.integer' => 'Price must be a number',

            'stock.required' => 'Stock is required.',
            'stock.integer' => 'Stock must be a number',

            'branch_id.required' => 'Branch ID is required.',
            'branch_id.integer' => 'Branch ID must be a number',
        ];
    }
}
