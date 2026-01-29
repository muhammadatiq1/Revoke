<x-layouts.app>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('offboarding.index') }}" class="text-blue-600 hover:text-blue-700 flex items-center gap-1 mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Offboarding
                </a>
                <h1 class="text-3xl font-bold text-gray-900">{{ $employee->name }}'s Offboarding</h1>
                <p class="text-gray-600 mt-1">{{ $employee->department }} • {{ $employee->email }}</p>
            </div>
            <div>
                <span class="inline-flex px-4 py-2 text-sm font-semibold rounded-full {{ $employee->status === 'terminated' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                    {{ ucfirst($employee->status) }}
                </span>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 flex items-start gap-3">
                <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Error Message -->
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 flex items-start gap-3">
                <svg class="w-5 h-5 text-red-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                <p class="text-red-800 font-medium">{{ session('error') }}</p>
            </div>
        @endif

        <!-- Kill List -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Revocation Tasks</h2>
                    <p class="text-sm text-gray-600 mt-1">Software access to revoke for this employee</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600">Total: <span class="text-2xl font-bold text-gray-900">{{ $offboardingTasks->count() }}</span></p>
                    <p class="text-xs text-gray-500 mt-1">
                        <span class="font-semibold text-yellow-600">{{ $offboardingTasks->where('status', 'pending')->count() }}</span> pending •
                        <span class="font-semibold text-green-600">{{ $offboardingTasks->where('status', 'revoked')->count() }}</span> revoked
                    </p>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Software</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Monthly Cost</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Risk Level</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($offboardingTasks as $task)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('softwares.show', $task->software) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">{{ $task->software->name }}</a>
                                    <p class="text-xs text-gray-500">{{ $task->software->website_url }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="text-sm font-semibold text-gray-900">${{ number_format($task->software->monthly_cost, 2) }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full {{ $task->software->risk_level === 'high' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($task->software->risk_level) }} Risk
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full {{ $task->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($task->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($task->status === 'pending')
                                        <form action="{{ route('offboarding.revoke', $task) }}" method="POST" class="inline" onsubmit="return confirm('Confirm revoke access to {{ $task->software->name }} for {{ $employee->name }}?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-blue-600 hover:text-blue-800 font-medium transition duration-150">
                                                Revoke Access
                                            </button>
                                        </form>
                                    @else
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="text-green-600 font-medium text-xs">{{ $task->revoked_at->format('M d, Y H:i') }}</span>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    <p>No offboarding tasks yet</p>
                                    @if($employee->status === 'active')
                                        <a href="{{ route('offboarding.initiate', $employee) }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm mt-2 inline-block">Initiate offboarding →</a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Summary -->
        @if($offboardingTasks->count() > 0)
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-blue-900 mb-4">Offboarding Summary</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <p class="text-blue-700 text-sm font-medium">Total Access Points</p>
                        <p class="text-2xl font-bold text-blue-900 mt-1">{{ $offboardingTasks->count() }}</p>
                    </div>
                    <div>
                        <p class="text-blue-700 text-sm font-medium">Completed</p>
                        <p class="text-2xl font-bold text-green-600 mt-1">{{ $offboardingTasks->where('status', 'revoked')->count() }}</p>
                    </div>
                    <div>
                        <p class="text-blue-700 text-sm font-medium">Remaining</p>
                        <p class="text-2xl font-bold text-yellow-600 mt-1">{{ $offboardingTasks->where('status', 'pending')->count() }}</p>
                    </div>
                    <div>
                        <p class="text-blue-700 text-sm font-medium">Total Monthly Savings</p>
                        <p class="text-2xl font-bold text-blue-900 mt-1">${{ number_format($offboardingTasks->sum(function($task) { return $task->software->monthly_cost; }), 2) }}</p>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-blue-200">
                    <p class="text-sm text-blue-800"><span class="font-semibold">{{ $offboardingTasks->filter(function($task) { return $task->software->risk_level === 'high'; })->count() }}</span> high-risk applications need attention</p>
                </div>
            </div>
        @endif
    </div>
</x-layouts.app>
