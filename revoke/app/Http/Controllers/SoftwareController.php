<?php

namespace App\Http\Controllers;

use App\Models\Software;
use App\Http\Requests\StoreSoftwareRequest;
use App\Http\Requests\UpdateSoftwareRequest;
use Illuminate\Http\Request;

class SoftwareController extends Controller
{
    /**
     * Display a listing of softwares.
     */
    public function index(Request $request)
    {
        $query = Software::withCount('employees');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('website_url', 'like', '%' . $request->search . '%');
        }

        // Filter by risk level
        if ($request->has('risk_level') && $request->risk_level) {
            $query->where('risk_level', $request->risk_level);
        }

        $softwares = $query->paginate(15);

        return view('softwares.index', compact('softwares'));
    }

    /**
     * Show the form for creating a new software.
     */
    public function create()
    {
        return view('softwares.create');
    }

    /**
     * Store a newly created software in database.
     */
    public function store(StoreSoftwareRequest $request)
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('softwares', 'public');
            $data['image'] = $path;
        }

        Software::create($data);
        return redirect()->route('softwares.index')->with('success', 'Application created successfully!');
    }

    /**
     * Display the specified software.
     */
    public function show(Software $software)
    {
        $software->load('employees');
        return view('softwares.show', compact('software'));
    }

    /**
     * Show the form for editing the specified software.
     */
    public function edit(Software $software)
    {
        return view('softwares.edit', compact('software'));
    }

    /**
     * Update the specified software in database.
     */
    public function update(UpdateSoftwareRequest $request, Software $software)
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($software->image && \Storage::disk('public')->exists($software->image)) {
                \Storage::disk('public')->delete($software->image);
            }
            $path = $request->file('image')->store('softwares', 'public');
            $data['image'] = $path;
        }

        $software->update($data);
        return redirect()->route('softwares.show', $software)->with('success', 'Application updated successfully!');
    }

    /**
     * Remove the specified software from database.
     */
    public function destroy(Software $software)
    {
        // Delete related offboarding tasks first
        $software->offboardingTasks()->delete();
        // Delete software-employee relationships
        $software->employees()->detach();
        // Delete the software
        $software->delete();

        return redirect()->route('softwares.index')->with('success', 'Application deleted successfully!');
    }

    /**
     * Delete multiple softwares in bulk.
     */
    public function bulkDelete(Request $request)
    {
        $ids = is_string($request->software_ids) 
            ? json_decode($request->software_ids, true) 
            : $request->software_ids;

        $request->validate([
            'software_ids' => 'required|array',
        ], [
            'software_ids.required' => 'Please select at least one application',
            'software_ids.array' => 'Invalid selection format',
        ]);

        $softwares = Software::whereIn('id', $ids)->get();
        $count = $softwares->count();

        foreach ($softwares as $software) {
            // Delete related offboarding tasks
            $software->offboardingTasks()->delete();
            // Delete software-employee relationships
            $software->employees()->detach();
            // Delete the software
            $software->delete();
        }

        return redirect()->route('softwares.index')->with('success', "Successfully deleted {$count} application(s)!");
    }
}
