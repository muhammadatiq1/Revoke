<x-layouts.app>
    <div class="space-y-6" x-data="{ selectedTasks: [], selectAll: false }">
        <!-- Header -->
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Offboarding Management</h1>
            <p class="text-gray-600 mt-1">Track and manage employee access revocation</p>
        </div>

        <!-- Bulk Revoke Form (Hidden) -->
        <form id="bulkRevokeForm" action="{{ route('offboarding.bulk-revoke') }}" method="POST" style="display: none;">
            @csrf
            @method('PATCH')
            <input type="hidden" id="bulkTaskIds" name="task_ids" value="">
        </form>

        <!-- Bulk Actions Bar -->
        <div id="bulkActionsBar" class="bg-blue-50 border-l-4 border-blue-600 p-4 rounded-lg hidden flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span id="selectedCount" class="text-blue-700 font-medium">0</span>
                <span class="text-blue-700">task(s) selected</span>
            </div>
            <button type="button" @click="
                if (confirm('Are you sure you want to revoke access for ' + selectedTasks.length + ' task(s)? This action cannot be undone.')) {
                    document.getElementById('bulkTaskIds').value = JSON.stringify(selectedTasks);
                    document.getElementById('bulkRevokeForm').submit();
                }
            " class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium text-sm">
                Revoke Selected
            </button>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-600 text-sm font-medium">Total Tasks</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-600 text-sm font-medium">Pending Revocation</p>
                <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $stats['pending'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-600 text-sm font-medium">Completed</p>
                <p class="text-3xl font-bold text-green-600 mt-2">{{ $stats['revoked'] }}</p>
            </div>
        </div>

        <!-- Search & Filter -->
        <div class="bg-white rounded-lg shadow p-4">
            <form method="GET" action="{{ route('offboarding.index') }}" class="flex gap-4 flex-wrap">
                <!-- Search Input -->
                <div class="flex-1 min-w-xs">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Search by employee name or email..." 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                    >
                </div>

                <!-- Status Filter -->
                <select 
                    name="status"
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                >
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="revoked" {{ request('status') === 'revoked' ? 'selected' : '' }}>Revoked</option>
                </select>

                <!-- Filter Button -->
                <button 
                    type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium"
                >
                    Filter
                </button>

                <!-- Clear Filters -->
                @if(request('search') || request('status'))
                    <a 
                        href="{{ route('offboarding.index') }}" 
                        class="px-6 py-2 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 transition font-medium"
                    >
                        Clear
                    </a>
                @endif
            </form>
        </div>

        <!-- Offboarding Tasks Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Offboarding Tasks</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                <input type="checkbox" id="selectAllCheckbox" x-model="selectAll" @change="
                                    document.querySelectorAll('.task-checkbox').forEach(cb => cb.checked = selectAll);
                                    selectedTasks = selectAll ? Array.from(document.querySelectorAll('.task-checkbox')).map(cb => cb.value) : [];
                                    document.getElementById('bulkActionsBar').classList.toggle('hidden', selectedTasks.length === 0);
                                    document.getElementById('selectedCount').textContent = selectedTasks.length;
                                " class="w-5 h-5 rounded cursor-pointer">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Employee</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Software</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Risk Level</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Initiated</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($offboardingTasks as $task)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($task->status === 'pending')
                                        <input type="checkbox" class="task-checkbox w-5 h-5 rounded cursor-pointer" value="{{ $task->id }}" 
                                            @change="
                                                selectedTasks = Array.from(document.querySelectorAll('.task-checkbox:checked')).map(cb => cb.value);
                                                selectAll = document.querySelectorAll('.task-checkbox').length === selectedTasks.length;
                                                document.getElementById('bulkActionsBar').classList.toggle('hidden', selectedTasks.length === 0);
                                                document.getElementById('selectedCount').textContent = selectedTasks.length;
                                                document.getElementById('selectAllCheckbox').checked = selectAll;
                                            ">
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <img src="{{ $task->employee->avatar_url }}" alt="{{ $task->employee->name }}" class="w-10 h-10 rounded-full mr-3">
                                        <div>
                                            <a href="{{ route('employees.show', $task->employee) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">{{ $task->employee->name }}</a>
                                            <p class="text-xs text-gray-500">{{ $task->employee->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('softwares.show', $task->software) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">{{ $task->software->name }}</a>
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
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $task->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($task->status === 'pending')
                                        <form action="{{ route('offboarding.revoke', $task) }}" method="POST" class="inline" onsubmit="return confirm('Confirm revoke access to {{ $task->software->name }}?');">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="from" value="offboarding.index">
                                            <button type="submit" class="text-blue-600 hover:text-blue-800 font-medium transition duration-150">
                                                Revoke Access
                                            </button>
                                        </form>
                                    @else
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="text-green-600 font-medium">Revoked</span>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                    <p>No offboarding tasks found</p>
                                    <a href="{{ route('employees.index') }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm mt-2 inline-block">Go to employees →</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $offboardingTasks->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>
