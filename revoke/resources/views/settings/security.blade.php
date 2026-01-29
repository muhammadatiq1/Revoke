<x-layouts.app>
    <div class="space-y-6">
        <!-- Header -->
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Settings</h1>
            <p class="text-gray-600 mt-1">Manage your application settings and preferences</p>
        </div>

        <!-- Settings Tabs -->
        <div class="flex gap-4 border-b border-gray-200 overflow-x-auto">
            <a href="{{ route('settings.general') }}" class="px-4 py-4 border-b-2 {{ request()->routeIs('settings.general') ? 'border-blue-600 text-blue-600 font-semibold' : 'border-transparent text-gray-600 hover:text-gray-900' }} transition duration-200 whitespace-nowrap">
                General
            </a>
            <a href="{{ route('settings.notifications') }}" class="px-4 py-4 border-b-2 {{ request()->routeIs('settings.notifications') ? 'border-blue-600 text-blue-600 font-semibold' : 'border-transparent text-gray-600 hover:text-gray-900' }} transition duration-200 whitespace-nowrap">
                Notifications
            </a>
            <a href="{{ route('settings.security') }}" class="px-4 py-4 border-b-2 {{ request()->routeIs('settings.security') ? 'border-blue-600 text-blue-600 font-semibold' : 'border-transparent text-gray-600 hover:text-gray-900' }} transition duration-200 whitespace-nowrap">
                Security
            </a>
            <a href="{{ route('settings.profile') }}" class="px-4 py-4 border-b-2 {{ request()->routeIs('settings.profile') ? 'border-blue-600 text-blue-600 font-semibold' : 'border-transparent text-gray-600 hover:text-gray-900' }} transition duration-200 whitespace-nowrap">
                Profile
            </a>
            <a href="{{ route('settings.roles') }}" class="px-4 py-4 border-b-2 {{ request()->routeIs('settings.roles') ? 'border-blue-600 text-blue-600 font-semibold' : 'border-transparent text-gray-600 hover:text-gray-900' }} transition duration-200 whitespace-nowrap">
                Roles & Permissions
            </a>
        </div>

        <!-- Security Settings Form -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Security Settings</h2>

            <form action="{{ route('settings.update-security') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Two Factor Authentication -->
                <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="font-semibold text-gray-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m7 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Two-Factor Authentication
                            </h3>
                            <p class="text-sm text-gray-600 mt-2">Add an extra layer of security to your account by requiring a second form of verification</p>
                        </div>
                        <input 
                            type="checkbox" 
                            name="enable_two_factor" 
                            value="1"
                            {{ old('enable_two_factor') ? 'checked' : '' }}
                            class="w-5 h-5 rounded cursor-pointer"
                        >
                    </div>
                    @if(old('enable_two_factor'))
                        <div class="mt-4 p-3 bg-blue-100 rounded border border-blue-300">
                            <p class="text-sm text-blue-900">⚠️ Two-factor authentication is enabled. You will be prompted for a verification code on login.</p>
                        </div>
                    @endif
                </div>

                <hr class="my-6">

                <h2 class="text-2xl font-bold text-gray-900 mb-6">Session Management</h2>

                <!-- Session Timeout -->
                <div>
                    <label for="session_timeout" class="block text-sm font-medium text-gray-700 mb-1">Session Timeout (minutes)</label>
                    <div class="flex gap-4">
                        <div class="flex-1">
                            <input 
                                type="number" 
                                id="session_timeout" 
                                name="session_timeout" 
                                min="5"
                                max="480"
                                value="{{ old('session_timeout', $settings?->session_timeout ?? 60) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                placeholder="60"
                            >
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 mt-2">You will be automatically logged out after this period of inactivity (5-480 minutes)</p>
                    @error('session_timeout') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex gap-3 pt-4">
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                        Save Settings
                    </button>
                    <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Active Sessions -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Active Sessions</h2>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 bg-green-50 border border-green-200 rounded">
                    <div>
                        <p class="font-medium text-gray-900">Current Session</p>
                        <p class="text-sm text-gray-600">{{ request()->userAgent() }}</p>
                    </div>
                    <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                        Active
                    </span>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
