<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
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
            'task_id' => 'required|numeric|exists:tasks,id',
            'member_id' => 'required|numeric|exists:members,id',
            'comment' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'task_id.required' => 'The task field is required.',
            'member_id.required' => 'The member is required.',
        ];
    }
}
