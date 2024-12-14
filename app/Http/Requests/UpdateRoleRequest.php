<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
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
        $role = $this->route('role');
        return [
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'guard_name' => 'required|string|in:admin,member,api-admin,api-member',
        ];
    }

    public function messages(): array
    {
        $role = $this->route('role');
        return [
            'guard_name.required' => 'The type field is required.',
        ];
    }
}
