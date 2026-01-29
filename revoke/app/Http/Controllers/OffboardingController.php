<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\OffboardingTask;
use App\Http\Requests\InitiateOffboardingRequest;
use Illuminate\Http\Request;

class OffboardingController extends Controller
{
    /**
     * Display the offboarding tasks listing.
     */
    public function index(Request $request)
    {
        $query = OffboardingTask::with(['employee', 'software']);

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Search by employee name or email
        if ($request->has('search') && $request->search) {
            $query->whereHas('employee', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Order by created_at descending
        $offboardingTasks = $query->orderBy('created_at', 'desc')->paginate(15);

        // Calculate summary statistics
        $stats = [
            'total' => OffboardingTask::count(),
            'pending' => OffboardingTask::where('status', 'pending')->count(),
            'revoked' => OffboardingTask::where('status', 'revoked')->count(),
        ];

        return view('offboarding.index', compact('offboardingTasks', 'stats'));
    }

    /**
     * Show a specific employee's offboarding details.
     */
    public function show(Employee $employee)
    {
        // Get or create offboarding tasks for this employee if they have software assigned
        $offboardingTasks = $employee->offboardingTasks()->with('software')->get();
        
        return view('offboarding.show', compact('employee', 'offboardingTasks'));
    }

    /**
     * Show the initiate offboarding confirmation form.
     */
    public function initiate(Employee $employee)
    {
        // Only allow offboarding for active employees
        if ($employee->status !== 'active') {
            return redirect()->route('employees.show', $employee)
                ->with('error', 'Only active employees can be offboarded.');
        }

        // Load assigned software
        $employee->load('softwares');

        return view('offboarding.initiate', compact('employee'));
    }

    /**
     * Initiate the offboarding process for an employee.
     * This creates offboarding tasks for all software currently assigned to the employee.
     */
    public function store(InitiateOffboardingRequest $request, Employee $employee)
    {
        // Only allow offboarding for active employees
        if ($employee->status !== 'active') {
            return redirect()->route('employees.show', $employee)
                ->with('error', 'Only active employees can be offboarded.');
        }

        // Update the employee's status to terminated
        $employee->update(['status' => 'terminated']);

        // Query all software currently assigned to this employee
        $softwares = $employee->softwares;

        // Create offboarding tasks for each software
        foreach ($softwares as $software) {
            OffboardingTask::firstOrCreate(
                [
                    'employee_id' => $employee->id,
                    'software_id' => $software->id,
                ],
                [
                    'status' => 'pending',
                    'revoked_at' => null,
                ]
            );
        }

        return redirect()->route('offboarding.show', $employee->id)
            ->with('success', "Offboarding process initiated for {$employee->name}. {$softwares->count()} access revocation tasks created.");
    }

    /**
     * Mark an offboarding task as revoked.
     */
    public function revoke(Request $request, OffboardingTask $offboardingTask)
    {
        $offboardingTask->update([
            'status' => 'revoked',
            'revoked_at' => now(),
        ]);

        // If coming from index, stay on index, otherwise go back to employee details
        $redirectTo = $request->input('from', 'offboarding.show');
        
        if ($redirectTo === 'offboarding.show') {
            return redirect()->route('offboarding.show', $offboardingTask->employee_id)
                ->with('success', "Access to {$offboardingTask->software->name} has been revoked for {$offboardingTask->employee->name}.");
        }

        return redirect()->route('offboarding.index')
            ->with('success', "Access to {$offboardingTask->software->name} has been revoked for {$offboardingTask->employee->name}.");
    }

    /**
     * Revoke multiple offboarding tasks in bulk.
     */
    public function bulkRevoke(Request $request)
    {
        $ids = is_string($request->task_ids) 
            ? json_decode($request->task_ids, true) 
            : $request->task_ids;

        $request->validate([
            'task_ids' => 'required|array',
        ], [
            'task_ids.required' => 'Please select at least one task',
            'task_ids.array' => 'Invalid selection format',
        ]);

        $tasks = OffboardingTask::whereIn('id', $ids)->where('status', 'pending')->get();
        $count = $tasks->count();

        foreach ($tasks as $task) {
            $task->update([
                'status' => 'revoked',
                'revoked_at' => now(),
            ]);
        }

        return redirect()->route('offboarding.index')
            ->with('success', "Successfully revoked access for {$count} task(s)!");
    }
}
