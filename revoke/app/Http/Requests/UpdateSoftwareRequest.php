<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSoftwareRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', Rule::unique('softwares', 'name')->ignore($this->software->id)],
            'monthly_cost' => 'required|numeric|min:0|max:99999.99',
            'risk_level' => 'required|in:low,high',
            'website_url' => 'nullable|url',            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Application name is required',
            'name.unique' => 'This application name already exists',
            'monthly_cost.required' => 'Monthly cost is required',
            'monthly_cost.numeric' => 'Monthly cost must be a valid number',
            'risk_level.required' => 'Risk level is required',
            'website_url.url' => 'Website URL must be a valid URL',
        ];
    }
}
