<x-layouts.app>
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('softwares.index') }}" class="text-blue-600 hover:text-blue-700 flex items-center gap-1 mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Applications
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Add New Application</h1>
            <p class="text-gray-600 mt-2">Register a new software tool in your system</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow p-8">
            <form action="{{ route('softwares.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-900 mb-2">
                        Application Name
                        <span class="text-red-600">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}"
                        placeholder="e.g., Microsoft Office 365, Slack, Asana"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('name') border-red-500 @enderror"
                    >
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Monthly Cost Field -->
                <div>
                    <label for="monthly_cost" class="block text-sm font-medium text-gray-900 mb-2">
                        Monthly Cost ($)
                        <span class="text-red-600">*</span>
                    </label>
                    <input 
                        type="number" 
                        id="monthly_cost" 
                        name="monthly_cost" 
                        value="{{ old('monthly_cost') }}"
                        placeholder="0.00"
                        step="0.01"
                        min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('monthly_cost') border-red-500 @enderror"
                    >
                    @error('monthly_cost')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Risk Level Field -->
                <div>
                    <label for="risk_level" class="block text-sm font-medium text-gray-900 mb-2">
                        Risk Level
                        <span class="text-red-600">*</span>
                    </label>
                    <select 
                        id="risk_level" 
                        name="risk_level"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('risk_level') border-red-500 @enderror"
                    >
                        <option value="">Select Risk Level</option>
                        <option value="low" {{ old('risk_level') === 'low' ? 'selected' : '' }}>Low Risk</option>
                        <option value="high" {{ old('risk_level') === 'high' ? 'selected' : '' }}>High Risk</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Low risk: Easily replaceable data | High risk: Critical/sensitive data</p>
                    @error('risk_level')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Website URL Field -->
                <div>
                    <label for="website_url" class="block text-sm font-medium text-gray-900 mb-2">
                        Website URL (Optional)
                    </label>
                    <input 
                        type="url" 
                        id="website_url" 
                        name="website_url" 
                        value="{{ old('website_url') }}"
                        placeholder="https://www.example.com"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('website_url') border-red-500 @enderror"
                    >
                    @error('website_url')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex gap-4 pt-6 border-t border-gray-200">
                    <button 
                        type="submit" 
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium"
                    >
                        Create Application
                    </button>
                    <a 
                        href="{{ route('softwares.index') }}" 
                        class="px-6 py-3 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 transition font-medium"
                    >
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
