<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('employees', 'email')->ignore($this->employee->id)],
            'department' => 'required|string|max:255',
            'status' => 'required|in:active,inactive,offboarded',
            'avatar_url' => 'nullable|url',            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Employee name is required',
            'email.required' => 'Employee email is required',
            'email.unique' => 'This email is already registered',
            'department.required' => 'Department is required',
            'status.required' => 'Status is required',
        ];
    }
}
