<x-layouts.app>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('employees.index') }}" class="text-blue-600 hover:text-blue-700 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <img src="{{ $employee->avatar_url }}" alt="{{ $employee->name }}" class="w-16 h-16 rounded-full mr-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $employee->name }}</h1>
                    <p class="text-gray-600 mt-1">{{ $employee->department }} • {{ $employee->email }}</p>
                </div>
            </div>
            <div class="flex gap-2">
                <span class="inline-flex px-4 py-2 text-sm font-semibold rounded-full {{ $employee->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ ucfirst($employee->status) }}
                </span>
                <a href="{{ route('employees.edit', $employee) }}" class="px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition font-medium">
                    Edit
                </a>
            </div>
        </div>

        <!-- Software Access -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Software Access</h2>
                <p class="text-sm text-gray-600 mt-1">{{ $employee->softwares->count() }} application(s) assigned</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Software</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Monthly Cost</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Risk Level</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Assigned Date</th>
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
                                    <p class="text-sm text-gray-900">${{ number_format($software->monthly_cost, 2) }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full {{ $software->risk_level === 'high' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($software->risk_level) }} Risk
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="text-sm text-gray-900">{{ $software->pivot->assigned_at->format('M d, Y') }}</p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                    No software assigned
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Summary Stats -->
        @if($employee->softwares->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-gray-600 text-sm font-medium">Total Monthly Cost</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">${{ number_format($employee->softwares->sum('monthly_cost'), 2) }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-gray-600 text-sm font-medium">High Risk Applications</p>
                    <p class="text-3xl font-bold text-red-600 mt-2">{{ $employee->softwares->where('risk_level', 'high')->count() }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-gray-600 text-sm font-medium">Low Risk Applications</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">{{ $employee->softwares->where('risk_level', 'low')->count() }}</p>
                </div>
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="flex gap-4">
            @if($employee->status === 'active')
                <a href="{{ route('offboarding.initiate', $employee) }}" class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-150 font-medium">
                    Initiate Offboarding
                </a>
            @else
                <form action="{{ route('employees.destroy', $employee) }}" method="POST" onsubmit="return confirm('Are you sure? This action cannot be undone. All related data will be permanently deleted.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-150 font-medium">
                        Delete Employee
                    </button>
                </form>
            @endif
        </div>
    </div>
</x-layouts.app>
