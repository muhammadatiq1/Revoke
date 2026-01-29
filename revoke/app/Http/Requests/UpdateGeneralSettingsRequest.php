<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGeneralSettingsRequest extends FormRequest
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
            'company_name' => 'required|string|max:255',
            'company_email' => 'nullable|email|max:255',
            'company_phone' => 'nullable|string|max:20',
            'company_address' => 'nullable|string|max:500',
            'timezone' => 'required|string|in:UTC,America/New_York,America/Chicago,America/Denver,America/Los_Angeles,Europe/London,Europe/Paris,Asia/Tokyo,Asia/Dubai,Australia/Sydney',
            'date_format' => 'required|string|in:M d, Y,d/m/Y,Y-m-d,m-d-Y',
            'currency' => 'required|string|in:USD,EUR,GBP,CAD,AUD,JPY',
        ];
    }
}
