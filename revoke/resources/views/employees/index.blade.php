<x-layouts.app>
    <div class="space-y-6" x-data="{ selectedEmployees: [], selectAll: false }">
        <!-- Header with Create Button -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Employees</h1>
                <p class="text-gray-600 mt-1">Manage all employees and their software access</p>
            </div>
            <a href="{{ route('employees.create') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Employee
            </a>
        </div>

        <!-- Bulk Delete Form (Hidden) -->
        <form id="bulkDeleteForm" action="{{ route('employees.bulk-delete') }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
            <input type="hidden" id="bulkEmployeeIds" name="employee_ids" value="">
        </form>

        <!-- Bulk Actions Bar -->
        <div id="bulkActionsBar" class="bg-blue-50 border-l-4 border-blue-600 p-4 rounded-lg hidden flex items-center justify-between">
            <div class="flex items-center gap-3">
                <input type="checkbox" id="selectAllCheckbox" x-model="selectAll" @change="
                    document.querySelectorAll('.employee-checkbox').forEach(cb => cb.checked = selectAll);
                    selectedEmployees = selectAll ? Array.from(document.querySelectorAll('.employee-checkbox')).map(cb => cb.value) : [];
                    document.getElementById('bulkActionsBar').classList.toggle('hidden', selectedEmployees.length === 0);
                    document.getElementById('selectedCount').textContent = selectedEmployees.length;
                " class="w-5 h-5 rounded cursor-pointer">
                <span id="selectedCount" class="text-blue-700 font-medium">0</span>
                <span class="text-blue-700">employee(s) selected</span>
            </div>
            <button type="button" @click="
                if (confirm('Are you sure you want to delete ' + selectedEmployees.length + ' employee(s)? This action cannot be undone.')) {
                    document.getElementById('bulkEmployeeIds').value = JSON.stringify(selectedEmployees);
                    document.getElementById('bulkDeleteForm').submit();
                }
            " class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium text-sm">
                Delete Selected
            </button>
        </div>

        <!-- Employees Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($employees as $employee)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition duration-200 overflow-hidden relative">
                    <input type="checkbox" class="employee-checkbox absolute top-4 left-4 w-5 h-5 rounded cursor-pointer z-10" value="{{ $employee->id }}" 
                        @change="
                            selectedEmployees = Array.from(document.querySelectorAll('.employee-checkbox:checked')).map(cb => cb.value);
                            selectAll = document.querySelectorAll('.employee-checkbox').length === selectedEmployees.length;
                            document.getElementById('bulkActionsBar').classList.toggle('hidden', selectedEmployees.length === 0);
                            document.getElementById('selectedCount').textContent = selectedEmployees.length;
                            document.getElementById('selectAllCheckbox').checked = selectAll;
                        ">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <img src="{{ $employee->avatar_url }}" alt="{{ $employee->name }}" class="w-12 h-12 rounded-full">
                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full {{ $employee->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($employee->status) }}
                            </span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $employee->name }}</h3>
                        <p class="text-sm text-gray-600 mt-1">{{ $employee->department }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $employee->email }}</p>
                        
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <p class="text-sm text-gray-600 mb-2">
                                <span class="font-semibold text-gray-900">{{ $employee->softwares->count() }}</span> software(s)
                            </p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($employee->softwares->take(3) as $software)
                                    <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded">{{ $software->name }}</span>
                                @endforeach
                                @if($employee->softwares->count() > 3)
                                    <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded">+{{ $employee->softwares->count() - 3 }} more</span>
                                @endif
                            </div>
                        </div>

                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('employees.show', $employee) }}" class="flex-1 text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-150 text-sm font-medium">
                                View
                            </a>
                            <a href="{{ route('employees.edit', $employee) }}" class="flex-1 text-center px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition duration-150 text-sm font-medium">
                                Edit
                            </a>
                            @if($employee->status === 'active')
                                <a href="{{ route('offboarding.initiate', $employee) }}" class="flex-1 text-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-150 text-sm font-medium">
                                    Offboard
                                </a>
                            @else
                                <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="flex-1" onsubmit="return confirm('Are you sure? This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-150 text-sm font-medium">
                                        Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-600 mb-4">No employees found</p>
                    <a href="{{ route('employees.create') }}" class="text-blue-600 hover:text-blue-700 font-medium">Create your first employee →</a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div>
            {{ $employees->links() }}
        </div>
    </div>
</x-layouts.app>
