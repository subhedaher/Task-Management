<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'project_id' => 'required|numeric|exists:projects,id',
            'name' => 'required|string',
            'priority' => 'required|string|in:low,medium,high',
            'status' => 'required|string|in:pending,processing,completed,cancled,overdue',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:today|after_or_equal:start_date',
            'description' => 'required|string',
            'members' => 'required|array',
            'members.*' => 'required|numeric|exists:members,id',
            'attachments' => 'nullable|array',
            'attachments.*' => 'nullable|file|mimes:jpg,png,jpeg,pdf,docx|max:2048'
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
            'project_id.required' => 'The project field is required.',
        ];
    }
}