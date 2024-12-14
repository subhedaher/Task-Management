<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDesignationRequest extends FormRequest
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
        return [
            'name' => 'required|string|unique:designations',
            'description' => 'required|string',
            'department_id' => 'required|nullable|exists:departments,id',
        ];
    }

    public function messages(): array
    {
        return [
            'department_id.required' => 'The department field is required.',
        ];
    }
}
