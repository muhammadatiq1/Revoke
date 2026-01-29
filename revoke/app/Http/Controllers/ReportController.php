<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Employee;
use App\Models\Software;
use App\Models\OffboardingTask;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display list of all reports.
     */
    public function index()
    {
        $reports = Report::orderBy('created_at', 'desc')->paginate(10);
        
        return view('reports.index', [
            'reports' => $reports,
        ]);
    }

    /**
     * Show generate new report page with options.
     */
    public function create()
    {
        return view('reports.create');
    }

    /**
     * Show specific report.
     */
    public function show(Report $report)
    {
        return view('reports.show', [
            'report' => $report,
        ]);
    }

    /**
     * Generate offboarding report.
     */
    public function generateOffboardingReport(Request $request)
    {
        $request->validate([
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date',
        ]);

        $dateFrom = $request->date_from ? \Carbon\Carbon::parse($request->date_from) : null;
        $dateTo = $request->date_to ? \Carbon\Carbon::parse($request->date_to)->endOfDay() : null;

        $query = OffboardingTask::with('employee', 'software');

        if ($dateFrom) {
            $query->where('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->where('created_at', '<=', $dateTo);
        }

        $tasks = $query->get();

        $stats = [
            'total_tasks' => $tasks->count(),
            'pending_tasks' => $tasks->where('status', 'pending')->count(),
            'revoked_tasks' => $tasks->where('status', 'revoked')->count(),
            'total_savings' => $tasks->where('status', 'revoked')->sum(fn($task) => $task->software->monthly_cost),
            'high_risk_revoked' => $tasks->where('status', 'revoked')
                ->where('software.risk_level', 'high')
                ->count(),
        ];

        $data = [
            'stats' => $stats,
            'tasks' => $tasks->map(fn($task) => [
                'id' => $task->id,
                'employee' => $task->employee->name,
                'software' => $task->software->name,
                'risk_level' => $task->software->risk_level,
                'monthly_cost' => $task->software->monthly_cost,
                'status' => $task->status,
                'initiated_at' => $task->created_at->format('M d, Y'),
                'revoked_at' => $task->revoked_at?->format('M d, Y'),
            ])->toArray(),
            'generated_at' => now()->format('M d, Y H:i'),
            'period' => $dateFrom && $dateTo 
                ? "{$dateFrom->format('M d, Y')} - {$dateTo->format('M d, Y')}"
                : 'All Time',
        ];

        $report = Report::create([
            'title' => 'Offboarding Report - ' . now()->format('M d, Y'),
            'type' => 'offboarding',
            'description' => 'Summary of employee offboarding activities and access revocation',
            'data' => $data,
            'status' => 'generated',
        ]);

        return redirect()->route('reports.show', $report)
            ->with('success', 'Offboarding report generated successfully!');
    }

    /**
     * Generate software audit report.
     */
    public function generateSoftwareAuditReport(Request $request)
    {
        $request->validate([
            'risk_level' => 'nullable|in:low,high',
            'min_cost' => 'nullable|numeric|min:0',
        ]);

        $softwares = Software::with('employees');

        if ($request->risk_level) {
            $softwares->where('risk_level', $request->risk_level);
        }
        if ($request->min_cost) {
            $softwares->where('monthly_cost', '>=', $request->min_cost);
        }

        $softwares = $softwares->get();

        $stats = [
            'total_applications' => $softwares->count(),
            'total_monthly_cost' => $softwares->sum('monthly_cost'),
            'total_yearly_cost' => $softwares->sum('monthly_cost') * 12,
            'high_risk_applications' => $softwares->where('risk_level', 'high')->count(),
            'average_users_per_app' => $softwares->count() > 0 
                ? round($softwares->sum(fn($s) => $s->employees_count) / $softwares->count(), 1)
                : 0,
        ];

        $data = [
            'stats' => $stats,
            'applications' => $softwares->map(fn($software) => [
                'id' => $software->id,
                'name' => $software->name,
                'website' => $software->website_url,
                'risk_level' => $software->risk_level,
                'monthly_cost' => $software->monthly_cost,
                'yearly_cost' => $software->monthly_cost * 12,
                'users_count' => $software->employees_count,
                'cost_per_user' => $software->employees_count > 0 
                    ? round($software->monthly_cost / $software->employees_count, 2)
                    : $software->monthly_cost,
            ])->sortByDesc('monthly_cost')->values()->toArray(),
            'generated_at' => now()->format('M d, Y H:i'),
        ];

        $report = Report::create([
            'title' => 'Software Audit Report - ' . now()->format('M d, Y'),
            'type' => 'software_audit',
            'description' => 'Comprehensive audit of all applications, costs, and risk levels',
            'data' => $data,
            'status' => 'generated',
        ]);

        return redirect()->route('reports.show', $report)
            ->with('success', 'Software audit report generated successfully!');
    }

    /**
     * Generate risk assessment report.
     */
    public function generateRiskAssessmentReport(Request $request)
    {
        $highRiskSoftwares = Software::where('risk_level', 'high')->with('employees')->get();
        $allEmployees = Employee::with('softwares')->get();

        $riskEmployees = $allEmployees->filter(function($employee) {
            return $employee->softwares->where('risk_level', 'high')->count() > 0;
        })->values();

        $stats = [
            'total_high_risk_apps' => $highRiskSoftwares->count(),
            'employees_with_high_risk_access' => $riskEmployees->count(),
            'total_high_risk_accesses' => $riskEmployees->sum(fn($e) => $e->softwares->where('risk_level', 'high')->count()),
            'high_risk_apps_cost' => $highRiskSoftwares->sum('monthly_cost'),
            'high_risk_apps_yearly_cost' => $highRiskSoftwares->sum('monthly_cost') * 12,
        ];

        $data = [
            'stats' => $stats,
            'high_risk_applications' => $highRiskSoftwares->map(fn($software) => [
                'id' => $software->id,
                'name' => $software->name,
                'monthly_cost' => $software->monthly_cost,
                'users_count' => $software->employees_count,
                'users' => $software->employees->pluck('name')->toArray(),
            ])->toArray(),
            'at_risk_employees' => $riskEmployees->map(fn($employee) => [
                'id' => $employee->id,
                'name' => $employee->name,
                'email' => $employee->email,
                'status' => $employee->status,
                'high_risk_apps' => $employee->softwares
                    ->where('risk_level', 'high')
                    ->pluck('name')
                    ->toArray(),
            ])->toArray(),
            'generated_at' => now()->format('M d, Y H:i'),
        ];

        $report = Report::create([
            'title' => 'Risk Assessment Report - ' . now()->format('M d, Y'),
            'type' => 'risk_assessment',
            'description' => 'Assessment of high-risk applications and employee access exposure',
            'data' => $data,
            'status' => 'generated',
        ]);

        return redirect()->route('reports.show', $report)
            ->with('success', 'Risk assessment report generated successfully!');
    }

    /**
     * Delete a report.
     */
    public function destroy(Report $report)
    {
        $report->delete();

        return redirect()->route('reports.index')
            ->with('success', 'Report deleted successfully!');
    }
}
