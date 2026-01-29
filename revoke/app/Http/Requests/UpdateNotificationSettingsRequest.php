<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNotificationSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'notify_offboarding' => 'nullable|boolean',
            'notify_high_risk' => 'nullable|boolean',
            'notify_reports' => 'nullable|boolean',
            'notification_email' => 'nullable|email|max:255',
            'auto_generate_reports' => 'nullable|boolean',
            'report_frequency' => 'required|string|in:weekly,monthly,quarterly',
        ];
    }
}
