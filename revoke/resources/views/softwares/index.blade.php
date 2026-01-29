<x-layouts.app>
    <div class="space-y-6" x-data="{ selectedSoftwares: [], selectAll: false }">
        <!-- Header with Create Button -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Applications</h1>
                <p class="text-gray-600 mt-1">Track all software tools and their usage</p>
            </div>
            <a href="{{ route('softwares.create') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Application
            </a>
        </div>

        <!-- Bulk Delete Form (Hidden) -->
        <form id="bulkDeleteForm" action="{{ route('softwares.bulk-delete') }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
            <input type="hidden" id="bulkSoftwareIds" name="software_ids" value="">
        </form>

        <!-- Bulk Actions Bar -->
        <div id="bulkActionsBar" class="bg-blue-50 border-l-4 border-blue-600 p-4 rounded-lg hidden flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span id="selectedCount" class="text-blue-700 font-medium">0</span>
                <span class="text-blue-700">application(s) selected</span>
            </div>
            <button type="button" @click="
                if (confirm('Are you sure you want to delete ' + selectedSoftwares.length + ' application(s)? This will remove all employee assignments.')) {
                    document.getElementById('bulkSoftwareIds').value = JSON.stringify(selectedSoftwares);
                    document.getElementById('bulkDeleteForm').submit();
                }
            " class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium text-sm">
                Delete Selected
            </button>
        </div>

        <!-- Search & Filter -->
        <div class="bg-white rounded-lg shadow p-4">
            <form method="GET" action="{{ route('softwares.index') }}" class="flex gap-4 flex-wrap">
                <!-- Search Input -->
                <div class="flex-1 min-w-xs">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Search applications..." 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                    >
                </div>

                <!-- Risk Level Filter -->
                <select 
                    name="risk_level"
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                >
                    <option value="">All Risk Levels</option>
                    <option value="low" {{ request('risk_level') === 'low' ? 'selected' : '' }}>Low Risk</option>
                    <option value="high" {{ request('risk_level') === 'high' ? 'selected' : '' }}>High Risk</option>
                </select>

                <!-- Filter Button -->
                <button 
                    type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium"
                >
                    Filter
                </button>

                <!-- Clear Filters -->
                @if(request('search') || request('risk_level'))
                    <a 
                        href="{{ route('softwares.index') }}" 
                        class="px-6 py-2 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 transition font-medium"
                    >
                        Clear
                    </a>
                @endif
            </form>
        </div>

        <!-- Softwares Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                <input type="checkbox" id="selectAllCheckbox" x-model="selectAll" @change="
                                    document.querySelectorAll('.software-checkbox').forEach(cb => cb.checked = selectAll);
                                    selectedSoftwares = selectAll ? Array.from(document.querySelectorAll('.software-checkbox')).map(cb => cb.value) : [];
                                    document.getElementById('bulkActionsBar').classList.toggle('hidden', selectedSoftwares.length === 0);
                                    document.getElementById('selectedCount').textContent = selectedSoftwares.length;
                                " class="w-5 h-5 rounded cursor-pointer">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Software</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Monthly Cost</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Risk Level</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Users</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($softwares as $software)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" class="software-checkbox w-5 h-5 rounded cursor-pointer" value="{{ $software->id }}" 
                                        @change="
                                            selectedSoftwares = Array.from(document.querySelectorAll('.software-checkbox:checked')).map(cb => cb.value);
                                            selectAll = document.querySelectorAll('.software-checkbox').length === selectedSoftwares.length;
                                            document.getElementById('bulkActionsBar').classList.toggle('hidden', selectedSoftwares.length === 0);
                                            document.getElementById('selectedCount').textContent = selectedSoftwares.length;
                                            document.getElementById('selectAllCheckbox').checked = selectAll;
                                        ">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="text-sm font-medium text-gray-900">{{ $software->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $software->website_url }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="text-sm font-semibold text-gray-900">${{ number_format($software->monthly_cost, 2) }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full {{ $software->risk_level === 'high' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($software->risk_level) }} Risk
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-medium text-gray-900">{{ $software->employees_count }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <a href="{{ route('softwares.show', $software) }}" class="text-blue-600 hover:text-blue-800 transition">
                                        View
                                    </a>
                                    <a href="{{ route('softwares.edit', $software) }}" class="text-amber-600 hover:text-amber-800 transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('softwares.destroy', $software) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure? This will also remove assignments from employees.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 transition">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    <p>No applications found</p>
                                    <a href="{{ route('softwares.create') }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm mt-2 inline-block">Create your first application →</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div>
            {{ $softwares->appends(request()->query())->links() }}
        </div>
    </div>
</x-layouts.app>
