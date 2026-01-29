<x-layouts.app>
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('employees.show', $employee) }}" class="text-blue-600 hover:text-blue-700 flex items-center gap-1 mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Employee
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Initiate Offboarding</h1>
            <p class="text-gray-600 mt-2">Start the access revocation process for {{ $employee->name }}</p>
        </div>

        <!-- Warning Card -->
        <div class="bg-red-50 border border-red-200 rounded-lg p-6 mb-8">
            <div class="flex gap-4">
                <svg class="w-6 h-6 text-red-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <h3 class="font-semibold text-red-900">Important: This Action is Irreversible</h3>
                    <p class="text-red-800 text-sm mt-1">Once offboarding is initiated, {{ $employee->name }}'s employee status will be changed to "terminated" and access revocation tasks will be created for all assigned applications.</p>
                </div>
            </div>
        </div>

        <!-- Employee Details -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Employee Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Name</p>
                    <p class="text-gray-900 font-medium mt-1">{{ $employee->name }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm font-medium">Email</p>
                    <p class="text-gray-900 font-medium mt-1">{{ $employee->email }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm font-medium">Department</p>
                    <p class="text-gray-900 font-medium mt-1">{{ $employee->department }}</p>
                </div>
            </div>
        </div>

        <!-- Applications to Revoke -->
        <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Applications to Revoke Access</h2>
                <p class="text-sm text-gray-600 mt-1">{{ $employee->softwares->count() }} application(s) will be included in the offboarding process</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Application</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Monthly Cost</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Risk Level</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($employee->softwares as $software)
                            <tr class="hover:bg-gray-50 transition duration-150">
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
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                                    This employee has no applications assigned
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($employee->softwares->count() > 0)
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-600">Total Monthly Savings</p>
                            <p class="text-2xl font-bold text-gray-900">${{ number_format($employee->softwares->sum('monthly_cost'), 2) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">High Risk Applications</p>
                            <p class="text-2xl font-bold text-red-600">{{ $employee->softwares->where('risk_level', 'high')->count() }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Confirmation Form -->
        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('offboarding.store', $employee) }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input 
                            type="checkbox" 
                            name="confirmed" 
                            value="1"
                            class="w-5 h-5 text-red-600 border-gray-300 rounded focus:ring-red-500 mt-0.5"
                            @error('confirmed') aria-invalid="true" @enderror
                        >
                        <div>
                            <p class="font-medium text-gray-900">I confirm that I want to proceed with offboarding</p>
                            <p class="text-sm text-gray-600 mt-1">I understand that this action will mark {{ $employee->name }}'s status as terminated and create access revocation tasks for all assigned applications.</p>
                            @error('confirmed')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </label>
                </div>

                <div class="flex gap-4 pt-4 border-t border-gray-200">
                    <button 
                        type="submit" 
                        class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium"
                    >
                        Proceed with Offboarding
                    </button>
                    <a 
                        href="{{ route('employees.show', $employee) }}" 
                        class="px-6 py-3 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 transition font-medium"
                    >
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
