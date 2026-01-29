<x-layouts.app>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('reports.index') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm mb-2 inline-block">← Back to Reports</a>
                <h1 class="text-3xl font-bold text-gray-900">{{ $report->title }}</h1>
                <p class="text-gray-600 mt-1">{{ $report->description }}</p>
            </div>
            <form action="{{ route('reports.destroy', $report) }}" method="POST" onsubmit="return confirm('Delete this report?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium text-sm">
                    Delete Report
                </button>
            </form>
        </div>

        <!-- Report Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-600 text-sm font-medium">Report Type</p>
                <p class="text-2xl font-bold text-gray-900 mt-2">{{ $report->getTypeLabel() }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-600 text-sm font-medium">Status</p>
                <div class="mt-2">
                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $report->getStatusColor() }}">
                        {{ ucfirst($report->status) }}
                    </span>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-600 text-sm font-medium">Generated</p>
                <p class="text-lg font-bold text-gray-900 mt-2">{{ $report->created_at->format('M d, Y H:i') }}</p>
            </div>
        </div>

        <!-- Report Content -->
        <div class="bg-white rounded-lg shadow p-6">
            @if($report->type === 'offboarding')
                <!-- Offboarding Report -->
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Offboarding Summary</h2>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4">
                        <p class="text-gray-600 text-sm font-medium">Total Tasks</p>
                        <p class="text-3xl font-bold text-blue-600 mt-2">{{ $report->data['stats']['total_tasks'] }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-lg p-4">
                        <p class="text-gray-600 text-sm font-medium">Pending</p>
                        <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $report->data['stats']['pending_tasks'] }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4">
                        <p class="text-gray-600 text-sm font-medium">Revoked</p>
                        <p class="text-3xl font-bold text-green-600 mt-2">{{ $report->data['stats']['revoked_tasks'] }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4">
                        <p class="text-gray-600 text-sm font-medium">Monthly Savings</p>
                        <p class="text-3xl font-bold text-purple-600 mt-2">${{ number_format($report->data['stats']['total_savings'], 2) }}</p>
                    </div>
                </div>

                <!-- Details -->
                <div class="mb-6">
                    <p class="text-sm text-gray-600"><strong>Period:</strong> {{ $report->data['period'] }}</p>
                    <p class="text-sm text-gray-600 mt-2"><strong>High Risk Revoked:</strong> {{ $report->data['stats']['high_risk_revoked'] }} access(es)</p>
                </div>

                <!-- Tasks Table -->
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Detailed Tasks</h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase">Employee</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase">Software</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase">Risk</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase">Cost</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase">Initiated</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase">Revoked</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($report->data['tasks'] as $task)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $task['employee'] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $task['software'] }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $task['risk_level'] === 'high' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                            {{ ucfirst($task['risk_level']) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900">${{ number_format($task['monthly_cost'], 2) }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $task['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                            {{ ucfirst($task['status']) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $task['initiated_at'] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $task['revoked_at'] ?? '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            @elseif($report->type === 'software_audit')
                <!-- Software Audit Report -->
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Software Audit Summary</h2>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4">
                        <p class="text-gray-600 text-sm font-medium">Total Applications</p>
                        <p class="text-3xl font-bold text-blue-600 mt-2">{{ $report->data['stats']['total_applications'] }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4">
                        <p class="text-gray-600 text-sm font-medium">Monthly Cost</p>
                        <p class="text-3xl font-bold text-green-600 mt-2">${{ number_format($report->data['stats']['total_monthly_cost'], 2) }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4">
                        <p class="text-gray-600 text-sm font-medium">Yearly Cost</p>
                        <p class="text-3xl font-bold text-purple-600 mt-2">${{ number_format($report->data['stats']['total_yearly_cost'], 2) }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-lg p-4">
                        <p class="text-gray-600 text-sm font-medium">High Risk Apps</p>
                        <p class="text-3xl font-bold text-red-600 mt-2">{{ $report->data['stats']['high_risk_applications'] }}</p>
                    </div>
                </div>

                <!-- Applications Table -->
                <h3 class="text-lg font-semibold text-gray-900 mb-4">All Applications</h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase">Application</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase">Risk</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase">Monthly Cost</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase">Yearly Cost</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase">Users</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase">Cost per User</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($report->data['applications'] as $app)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm">
                                        <p class="font-medium text-gray-900">{{ $app['name'] }}</p>
                                        <p class="text-xs text-gray-500">{{ $app['website'] }}</p>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $app['risk_level'] === 'high' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                            {{ ucfirst($app['risk_level']) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">${{ number_format($app['monthly_cost'], 2) }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">${{ number_format($app['yearly_cost'], 2) }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $app['users_count'] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">${{ number_format($app['cost_per_user'], 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            @elseif($report->type === 'risk_assessment')
                <!-- Risk Assessment Report -->
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Risk Assessment Summary</h2>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-lg p-4">
                        <p class="text-gray-600 text-sm font-medium">High Risk Apps</p>
                        <p class="text-3xl font-bold text-red-600 mt-2">{{ $report->data['stats']['total_high_risk_apps'] }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg p-4">
                        <p class="text-gray-600 text-sm font-medium">At Risk Employees</p>
                        <p class="text-3xl font-bold text-orange-600 mt-2">{{ $report->data['stats']['employees_with_high_risk_access'] }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4">
                        <p class="text-gray-600 text-sm font-medium">High Risk Accesses</p>
                        <p class="text-3xl font-bold text-purple-600 mt-2">{{ $report->data['stats']['total_high_risk_accesses'] }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4">
                        <p class="text-gray-600 text-sm font-medium">Annual Risk Cost</p>
                        <p class="text-3xl font-bold text-blue-600 mt-2">${{ number_format($report->data['stats']['high_risk_apps_yearly_cost'], 2) }}</p>
                    </div>
                </div>

                <!-- High Risk Applications -->
                <h3 class="text-lg font-semibold text-gray-900 mb-4">High Risk Applications</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                    @foreach($report->data['high_risk_applications'] as $app)
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-900 mb-2">{{ $app['name'] }}</h4>
                            <div class="space-y-2 text-sm">
                                <p><span class="font-medium text-gray-700">Monthly Cost:</span> <span class="text-gray-600">${{ number_format($app['monthly_cost'], 2) }}</span></p>
                                <p><span class="font-medium text-gray-700">Users:</span> <span class="text-gray-600">{{ $app['users_count'] }}</span></p>
                                <div class="pt-2 border-t border-red-200">
                                    <p class="font-medium text-gray-700 mb-2">Access by:</p>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($app['users'] as $user)
                                            <span class="inline-flex px-2 py-1 text-xs bg-red-100 text-red-800 rounded">{{ $user }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- At Risk Employees -->
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Employees With High Risk Access</h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase">Employee</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase">High Risk Apps</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($report->data['at_risk_employees'] as $emp)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm">
                                        <p class="font-medium text-gray-900">{{ $emp['name'] }}</p>
                                        <p class="text-xs text-gray-500">{{ $emp['email'] }}</p>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $emp['status'] === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($emp['status']) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($emp['high_risk_apps'] as $app)
                                                <span class="inline-flex px-2 py-1 text-xs bg-red-100 text-red-800 rounded">{{ $app }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 rounded-lg p-4 text-center text-sm text-gray-600">
            <p>Report generated on {{ $report->data['generated_at'] ?? 'Unknown' }}</p>
        </div>
    </div>
</x-layouts.app>
