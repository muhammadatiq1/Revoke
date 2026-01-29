<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Seed roles and permissions
        $this->call(RolePermissionSeeder::class);

        // Demo seeders disabled - no sample data
        // Uncomment below to add demo data
        // $this->call(SoftwareSeeder::class);
        // $this->call(EmployeeSeeder::class);
        // $this->call(OffboardingTaskSeeder::class);
    }
}
