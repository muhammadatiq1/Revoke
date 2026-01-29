<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name',
        'email',
        'department',
        'status',
        'avatar_url',
        'image',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    /**
     * Get all softwares assigned to this employee.
     */
    public function softwares()
    {
        return $this->belongsToMany(Software::class, 'employee_software')
            ->withPivot('assigned_at')
            ->withTimestamps();
    }

    /**
     * Get all offboarding tasks for this employee.
     */
    public function offboardingTasks()
    {
        return $this->hasMany(OffboardingTask::class);
    }
}
