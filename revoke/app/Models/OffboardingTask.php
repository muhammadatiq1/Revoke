<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OffboardingTask extends Model
{
    protected $fillable = [
        'employee_id',
        'software_id',
        'status',
        'revoked_at',
    ];

    protected $casts = [
        'status' => 'string',
        'revoked_at' => 'datetime',
    ];

    /**
     * Get the employee associated with this task.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Get the software associated with this task.
     */
    public function software()
    {
        return $this->belongsTo(Software::class);
    }
}
