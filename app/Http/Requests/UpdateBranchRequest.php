<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBranchRequest extends FormRequest
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
    public function rules(): array
    {
        $branchId = $this->route('branch')->id;
        return [
            'name' => ['required', 'string', 'max:255', 'unique:branches,name,' . $branchId],
            'location' => ['required', 'string', 'max:255', 'unique:branches,location,' . $branchId],
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be a string.',
            'name.max' => 'Name must not exceed 255 characters.',
            'name.unique' => 'Name must be unique.',

            'Location.required' => 'Location is required.',
            'Location.string' => 'Location must be a string.',
            'Location.max' => 'Location must not exceed 255 characters.',
            'Location.unique' => 'Location must be unique.',
        ];
    }
}
