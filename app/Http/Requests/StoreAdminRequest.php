<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreAdminRequest extends FormRequest
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
            'role_id' => 'required|numeric|exists:roles,id',
            'name' => 'required|string',
            'email' => 'required|email|unique:admins',
            'phone' => 'required|string|unique:admins',
            'address' => 'required|string',
            'password' => ['required', 'string', Password::min(8)->uncompromised()->letters()->mixedCase()->numbers()->symbols(), 'confirmed'],
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
