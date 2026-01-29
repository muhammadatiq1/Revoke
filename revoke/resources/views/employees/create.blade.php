<x-layouts.app>
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('employees.index') }}" class="text-blue-600 hover:text-blue-700 flex items-center gap-1 mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Employees
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Add New Employee</h1>
            <p class="text-gray-600 mt-2">Create a new employee record in your system</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow p-8">
            <form action="{{ route('employees.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-900 mb-2">
                        Employee Name
                        <span class="text-red-600">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}"
                        placeholder="John Doe"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('name') border-red-500 @enderror"
                    >
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-900 mb-2">
                        Email Address
                        <span class="text-red-600">*</span>
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        placeholder="john.doe@company.com"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('email') border-red-500 @enderror"
                    >
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Department Field -->
                <div>
                    <label for="department" class="block text-sm font-medium text-gray-900 mb-2">
                        Department
                        <span class="text-red-600">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="department" 
                        name="department" 
                        value="{{ old('department') }}"
                        placeholder="Engineering, Sales, Marketing, etc."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('department') border-red-500 @enderror"
                    >
                    @error('department')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Field -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-900 mb-2">
                        Status
                        <span class="text-red-600">*</span>
                    </label>
                    <select 
                        id="status" 
                        name="status"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('status') border-red-500 @enderror"
                    >
                        <option value="">Select Status</option>
                        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="offboarded" {{ old('status') === 'offboarded' ? 'selected' : '' }}>Offboarded</option>
                    </select>
                    @error('status')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Avatar URL Field -->
                <div>
                    <label for="avatar_url" class="block text-sm font-medium text-gray-900 mb-2">
                        Avatar URL (Optional)
                    </label>
                    <input 
                        type="url" 
                        id="avatar_url" 
                        name="avatar_url" 
                        value="{{ old('avatar_url') }}"
                        placeholder="https://example.com/avatar.jpg"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('avatar_url') border-red-500 @enderror"
                    >
                    <p class="text-xs text-gray-500 mt-1">Leave blank to use a default avatar</p>
                    @error('avatar_url')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex gap-4 pt-6 border-t border-gray-200">
                    <button 
                        type="submit" 
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium"
                    >
                        Create Employee
                    </button>
                    <a 
                        href="{{ route('employees.index') }}" 
                        class="px-6 py-3 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 transition font-medium"
                    >
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
