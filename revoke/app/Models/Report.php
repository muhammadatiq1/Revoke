<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'title',
        'type',
        'description',
        'data',
        'status',
        'exported_format',
        'exported_at',
    ];

    protected $casts = [
        'data' => 'array',
        'exported_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getTypeLabel(): string
    {
        return match($this->type) {
            'offboarding' => 'Offboarding Report',
            'software_audit' => 'Software Audit Report',
            'risk_assessment' => 'Risk Assessment Report',
            default => 'Unknown Report',
        };
    }

    public function getStatusColor(): string
    {
        return match($this->status) {
            'draft' => 'bg-gray-100 text-gray-800',
            'generated' => 'bg-blue-100 text-blue-800',
            'exported' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
