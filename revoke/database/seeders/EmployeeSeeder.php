<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Software;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = ['Engineering', 'Sales', 'Marketing', 'HR', 'Finance', 'Operations'];
        $firstNames = ['John', 'Jane', 'Michael', 'Sarah', 'Robert', 'Emily', 'David', 'Jessica', 'James', 'Lisa', 'William', 'Karen', 'Richard', 'Nancy', 'Joseph', 'Mary'];
        $lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez', 'Hernandez', 'Lopez', 'Gonzalez', 'Wilson', 'Anderson', 'Thomas'];

        $employees = [];
        for ($i = 0; $i < 20; $i++) {
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            
            $employees[] = [
                'name' => $firstName . ' ' . $lastName,
                'email' => strtolower($firstName) . '.' . strtolower($lastName) . '@company.com',
                'department' => $departments[array_rand($departments)],
                'status' => 'active',
                'avatar_url' => 'https://i.pravatar.cc/150?img=' . $i,
            ];
        }

        // Mark 2 employees as terminated
        $employees[0]['status'] = 'terminated';
        $employees[1]['status'] = 'terminated';

        // Create employees
        $createdEmployees = [];
        foreach ($employees as $employee) {
            $createdEmployees[] = Employee::create($employee);
        }

        // Randomly assign 3-5 softwares to each employee
        $softwares = Software::all();
        foreach ($createdEmployees as $employee) {
            $randomSoftwares = $softwares->random(rand(3, 5));
            $employee->softwares()->attach(
                $randomSoftwares->pluck('id')->toArray(),
                ['assigned_at' => now()->subDays(rand(1, 90))]
            );
        }
    }
}
