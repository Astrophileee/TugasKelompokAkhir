<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:branches,name'],
            'location' => ['required', 'string', 'max:255', 'unique:branches,location']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be a string.',
            'name.max' => 'Name must not exceed 255 characters.',
            'name.unique' => 'Name must be unique.',


            'location.required' => 'Location is required.',
            'location.string' => 'Location must be a string.',
            'location.max' => 'Location must not exceed 25 characters.',
            'location.unique' => 'Location must be unique.',
        ];
    }
}
