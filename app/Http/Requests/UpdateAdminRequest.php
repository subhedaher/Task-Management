<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
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
        $admin = $this->route('admin'); // Assuming route model binding is used

        return [
            'role_id' => 'required|numeric|exists:roles,id',
            'name' => 'required|string',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'phone' => 'required|string|unique:admins,phone,' . $admin->id,
            'address' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,png',
        ];
    }

    /**
     * Get the custom validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'role_id.required' => 'The role field is required.',
        ];
    }
}
