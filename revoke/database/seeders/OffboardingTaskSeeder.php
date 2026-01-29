<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\OffboardingTask;
use Illuminate\Database\Seeder;

class OffboardingTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get terminated employees
        $terminatedEmployees = Employee::where('status', 'terminated')->get();

        foreach ($terminatedEmployees as $employee) {
            // Get all softwares assigned to this employee
            $softwares = $employee->softwares;

            foreach ($softwares as $software) {
                OffboardingTask::create([
                    'employee_id' => $employee->id,
                    'software_id' => $software->id,
                    'status' => 'pending',
                    'revoked_at' => null,
                ]);
            }
        }
    }
}
