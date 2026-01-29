<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'company_name',
        'company_email',
        'company_phone',
        'company_address',
        'timezone',
        'date_format',
        'currency',
        'notify_offboarding',
        'notify_high_risk',
        'notify_reports',
        'notification_email',
        'auto_generate_reports',
        'report_frequency',
        'enable_two_factor',
        'session_timeout',
    ];

    protected $casts = [
        'notify_offboarding' => 'boolean',
        'notify_high_risk' => 'boolean',
        'notify_reports' => 'boolean',
        'auto_generate_reports' => 'boolean',
        'enable_two_factor' => 'boolean',
        'session_timeout' => 'integer',
    ];

    // Get single setting instance (singleton pattern)
    public static function instance()
    {
        return self::firstOrCreate([]);
    }
}
