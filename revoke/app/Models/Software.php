<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Software extends Model
{
    protected $table = 'softwares';

    protected $fillable = [
        'name',
        'monthly_cost',
        'risk_level',
        'website_url',
        'image',
    ];

    protected $casts = [
        'monthly_cost' => 'decimal:2',
        'risk_level' => 'string',
    ];

    /**
     * Get all employees using this software.
     */
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_software')
            ->withPivot('assigned_at')
            ->withTimestamps();
    }

    /**
     * Get all offboarding tasks for this software.
     */
    public function offboardingTasks()
    {
        return $this->hasMany(OffboardingTask::class);
    }
}
