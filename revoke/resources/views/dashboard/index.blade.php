<x-layouts.app>
    <div class="space-y-8">
        <!-- Dashboard Header with Logout -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Welcome, {{ auth()->user()->name }}!</h1>
                <p class="text-gray-600 mt-2">Here's an overview of your organization</p>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition duration-200 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
        
        <!-- OPERATIONS OVERVIEW Section -->
        <div>
            <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-6">Operations Overview</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Total Software -->
                <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
                    <p class="text-gray-500 text-sm uppercase tracking-wider font-semibold">Total Software</p>
                    <p class="text-4xl font-bold text-gray-900 mt-3">{{ \App\Models\Software::count() }}</p>
                    <p class="text-xs text-gray-400 mt-2">Active licenses</p>
                </div>

                <!-- Total Monthly Spend -->
                <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
                    <p class="text-gray-500 text-sm uppercase tracking-wider font-semibold">Total Monthly Spend</p>
                    <p class="text-4xl font-bold text-gray-900 mt-3">${{ number_format($totalMonthlySpend, 2) }}</p>
                    <p class="text-xs text-gray-400 mt-2">All costs combined</p>
                </div>

                <!-- Pending Tasks -->
                <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
                    <p class="text-gray-500 text-sm uppercase tracking-wider font-semibold">Pending Tasks</p>
                    <p class="text-4xl font-bold text-red-600 mt-3">{{ $pendingOffboardingTasks }}</p>
                    <p class="text-xs text-gray-400 mt-2">Awaiting action</p>
                </div>

                <!-- Active Employees -->
                <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
                    <p class="text-gray-500 text-sm uppercase tracking-wider font-semibold">Active Employees</p>
                    <p class="text-4xl font-bold text-emerald-600 mt-3">{{ $activeEmployees }}</p>
                    <p class="text-xs text-gray-400 mt-2">Currently active</p>
                </div>
            </div>
        </div>

        <!-- QUICK ACTIONS Section -->
        <div>
            <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-6">Quick Actions</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Offboard Employee Card -->
                <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200 hover:shadow-xl transition">
                    <div class="flex items-start justify-between mb-6">
                        <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2m0 0v-8m0 8l6.894-4.447"></path>
                        </svg>
                    </div>
                    <h3 class="text-gray-900 font-bold text-lg">Offboard Employee</h3>
                    <p class="text-gray-600 text-sm mt-2">Revoke access to all applications</p>
                    <a href="{{ route('employees.index') }}" class="inline-block mt-6 px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition">
                        Start Now →
                    </a>
                </div>

                <!-- Review Pending Card -->
                <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200 hover:shadow-xl transition">
                    <div class="flex items-start justify-between mb-6">
                        <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3"></path>
                        </svg>
                    </div>
                    <h3 class="text-gray-900 font-bold text-lg">Review Pending Tasks</h3>
                    <p class="text-gray-600 text-sm mt-2">{{ $pendingOffboardingTasks }} offboarding tasks</p>
                    <a href="{{ route('offboarding.index') }}" class="inline-block mt-6 px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition">
                        Review Now →
                    </a>
                </div>

                <!-- Add Software Card -->
                <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200 hover:shadow-xl transition">
                    <div class="flex items-start justify-between mb-6">
                        <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <h3 class="text-gray-900 font-bold text-lg">Add Software</h3>
                    <p class="text-gray-600 text-sm mt-2">Track new applications</p>
                    <a href="{{ route('softwares.index') }}" class="inline-block mt-6 px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition">
                        Add Now →
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div>
            <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-6">Recent Activity</h2>
            <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Employee</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Software</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($recentActivities as $activity)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $activity->employee->avatar_url }}" alt="{{ $activity->employee->name }}" class="w-9 h-9 rounded-full">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $activity->employee->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $activity->employee->department }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $activity->software->name }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full {{ $activity->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                            {{ ucfirst($activity->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $activity->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                        No recent activities
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
