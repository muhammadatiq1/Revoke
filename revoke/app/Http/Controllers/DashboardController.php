<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\OffboardingTask;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        // Calculate total monthly spend (sum of software costs for active employees)
        $totalMonthlySpend = \DB::table('softwares')
            ->join('employee_software', 'softwares.id', '=', 'employee_software.software_id')
            ->join('employees', 'employees.id', '=', 'employee_software.employee_id')
            ->where('employees.status', 'active')
            ->sum('softwares.monthly_cost');

        // Count pending offboarding tasks
        $pendingOffboardingTasks = OffboardingTask::where('status', 'pending')->count();

        // Count active employees
        $activeEmployees = Employee::where('status', 'active')->count();

        // Get recent offboarding tasks (latest 5)
        $recentActivities = OffboardingTask::with(['employee', 'software'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'totalMonthlySpend',
            'pendingOffboardingTasks',
            'activeEmployees',
            'recentActivities'
        ));
    }
}
