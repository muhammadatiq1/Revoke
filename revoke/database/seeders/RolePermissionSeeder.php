<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            // Dashboard
            ['name' => 'dashboard.view', 'display_name' => 'View Dashboard', 'module' => 'Dashboard'],
            
            // Employees
            ['name' => 'employees.view', 'display_name' => 'View Employees', 'module' => 'Employees'],
            ['name' => 'employees.create', 'display_name' => 'Create Employees', 'module' => 'Employees'],
            ['name' => 'employees.edit', 'display_name' => 'Edit Employees', 'module' => 'Employees'],
            ['name' => 'employees.delete', 'display_name' => 'Delete Employees', 'module' => 'Employees'],
            
            // Software
            ['name' => 'software.view', 'display_name' => 'View Software', 'module' => 'Software'],
            ['name' => 'software.create', 'display_name' => 'Create Software', 'module' => 'Software'],
            ['name' => 'software.edit', 'display_name' => 'Edit Software', 'module' => 'Software'],
            ['name' => 'software.delete', 'display_name' => 'Delete Software', 'module' => 'Software'],
            
            // Offboarding
            ['name' => 'offboarding.view', 'display_name' => 'View Offboarding', 'module' => 'Offboarding'],
            ['name' => 'offboarding.initiate', 'display_name' => 'Initiate Offboarding', 'module' => 'Offboarding'],
            ['name' => 'offboarding.revoke', 'display_name' => 'Revoke Access', 'module' => 'Offboarding'],
            
            // Reports
            ['name' => 'reports.view', 'display_name' => 'View Reports', 'module' => 'Reports'],
            ['name' => 'reports.create', 'display_name' => 'Generate Reports', 'module' => 'Reports'],
            ['name' => 'reports.delete', 'display_name' => 'Delete Reports', 'module' => 'Reports'],
            
            // Settings
            ['name' => 'settings.view', 'display_name' => 'View Settings', 'module' => 'Settings'],
            ['name' => 'settings.manage', 'display_name' => 'Manage Settings', 'module' => 'Settings'],
            
            // Roles & Permissions Management
            ['name' => 'roles.view', 'display_name' => 'View Roles', 'module' => 'Roles'],
            ['name' => 'roles.create', 'display_name' => 'Create Roles', 'module' => 'Roles'],
            ['name' => 'roles.edit', 'display_name' => 'Edit Roles', 'module' => 'Roles'],
            ['name' => 'roles.delete', 'display_name' => 'Delete Roles', 'module' => 'Roles'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission['name']], $permission);
        }

        // Create roles
        $admin = Role::updateOrCreate(
            ['name' => 'admin'],
            ['display_name' => 'Administrator', 'description' => 'Full system access']
        );

        $manager = Role::updateOrCreate(
            ['name' => 'manager'],
            ['display_name' => 'Manager', 'description' => 'Can manage employees and view offboarding']
        );

        $auditor = Role::updateOrCreate(
            ['name' => 'auditor'],
            ['display_name' => 'Auditor', 'description' => 'Read-only access to all reports and data']
        );

        $viewer = Role::updateOrCreate(
            ['name' => 'viewer'],
            ['display_name' => 'Viewer', 'description' => 'Can only view dashboard and reports']
        );

        // Assign permissions to roles
        $allPermissions = Permission::all();
        $admin->permissions()->sync($allPermissions->pluck('id'));

        $managerPermissions = Permission::whereIn('name', [
            'dashboard.view',
            'employees.view', 'employees.create', 'employees.edit', 'employees.delete',
            'software.view', 'software.create', 'software.edit', 'software.delete',
            'offboarding.view', 'offboarding.initiate', 'offboarding.revoke',
            'reports.view',
            'settings.view',
        ])->pluck('id');
        $manager->permissions()->sync($managerPermissions);

        $auditorPermissions = Permission::whereIn('name', [
            'dashboard.view',
            'employees.view',
            'software.view',
            'offboarding.view',
            'reports.view',
            'settings.view',
        ])->pluck('id');
        $auditor->permissions()->sync($auditorPermissions);

        $viewerPermissions = Permission::whereIn('name', [
            'dashboard.view',
            'reports.view',
        ])->pluck('id');
        $viewer->permissions()->sync($viewerPermissions);

        // Assign admin role to first user
        $user = User::first();
        if ($user) {
            $user->assignRole('admin');
        }
    }
}
