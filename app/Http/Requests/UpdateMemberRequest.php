<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMemberRequest extends FormRequest
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
        $member = $this->route('member');
        return [
            'role_id' => 'required|numeric|exists:roles,id',
            'name' => 'required|string',
            'email' => 'required|email|unique:members,email,' . $member->id,
            'phone' => 'required|string|unique:members,phone,' . $member->id,
            'address' => 'required|string',
            'designation_id' => 'required|numeric|exists:designations,id',
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
            'designation_id.required' => 'The designation field is required.',
        ];
    }
}
