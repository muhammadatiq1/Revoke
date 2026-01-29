<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of employees.
     */
    public function index()
    {
        $employees = Employee::with('softwares')
            ->paginate(15);

        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new employee.
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store a newly created employee in database.
     */
    public function store(StoreEmployeeRequest $request)
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('employees', 'public');
            $data['image'] = $path;
        }

        Employee::create($data);
        return redirect()->route('employees.index')->with('success', 'Employee created successfully!');
    }

    /**
     * Display the specified employee.
     */
    public function show(Employee $employee)
    {
        $employee->load('softwares');
        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified employee.
     */
    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    /**
     * Update the specified employee in database.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($employee->image && \Storage::disk('public')->exists($employee->image)) {
                \Storage::disk('public')->delete($employee->image);
            }
            $path = $request->file('image')->store('employees', 'public');
            $data['image'] = $path;
        }

        $employee->update($data);
        return redirect()->route('employees.show', $employee)->with('success', 'Employee updated successfully!');
    }

    /**
     * Remove the specified employee from database.
     */
    public function destroy(Employee $employee)
    {
        // Delete related offboarding tasks first
        $employee->offboardingTasks()->delete();
        // Delete employee-software relationships
        $employee->softwares()->detach();
        // Delete the employee
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully!');
    }

    /**
     * Delete multiple employees in bulk.
     */
    public function bulkDelete(Request $request)
    {
        $ids = is_string($request->employee_ids) 
            ? json_decode($request->employee_ids, true) 
            : $request->employee_ids;

        $request->validate([
            'employee_ids' => 'required|array',
        ], [
            'employee_ids.required' => 'Please select at least one employee',
            'employee_ids.array' => 'Invalid selection format',
        ]);

        $employees = Employee::whereIn('id', $ids)->get();
        $count = $employees->count();

        foreach ($employees as $employee) {
            // Delete related offboarding tasks
            $employee->offboardingTasks()->delete();
            // Delete employee-software relationships
            $employee->softwares()->detach();
            // Delete the employee
            $employee->delete();
        }

        return redirect()->route('employees.index')->with('success', "Successfully deleted {$count} employee(s)!");
    }
}

