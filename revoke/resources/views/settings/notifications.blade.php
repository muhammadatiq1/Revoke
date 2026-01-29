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

        <!-- Notification Settings Form -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Notification Preferences</h2>

            <form action="{{ route('settings.update-notifications') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Offboarding Notifications -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div>
                        <h3 class="font-semibold text-gray-900">Offboarding Alerts</h3>
                        <p class="text-sm text-gray-600 mt-1">Receive notifications when employees are offboarded</p>
                    </div>
                    <input 
                        type="checkbox" 
                        name="notify_offboarding" 
                        value="1"
                        {{ old('notify_offboarding', $settings->notify_offboarding) ? 'checked' : '' }}
                        class="w-5 h-5 rounded cursor-pointer"
                    >
                </div>

                <!-- High Risk Alerts -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div>
                        <h3 class="font-semibold text-gray-900">High-Risk Application Alerts</h3>
                        <p class="text-sm text-gray-600 mt-1">Get notified about high-risk applications and access changes</p>
                    </div>
                    <input 
                        type="checkbox" 
                        name="notify_high_risk" 
                        value="1"
                        {{ old('notify_high_risk', $settings->notify_high_risk) ? 'checked' : '' }}
                        class="w-5 h-5 rounded cursor-pointer"
                    >
                </div>

                <!-- Report Notifications -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div>
                        <h3 class="font-semibold text-gray-900">Report Notifications</h3>
                        <p class="text-sm text-gray-600 mt-1">Receive notifications when reports are generated</p>
                    </div>
                    <input 
                        type="checkbox" 
                        name="notify_reports" 
                        value="1"
                        {{ old('notify_reports', $settings->notify_reports) ? 'checked' : '' }}
                        class="w-5 h-5 rounded cursor-pointer"
                    >
                </div>

                <hr class="my-6">

                <h2 class="text-2xl font-bold text-gray-900 mb-6">Notification Contact</h2>

                <!-- Notification Email -->
                <div>
                    <label for="notification_email" class="block text-sm font-medium text-gray-700 mb-1">Notification Email Address</label>
                    <input 
                        type="email" 
                        id="notification_email" 
                        name="notification_email" 
                        value="{{ old('notification_email', $settings->notification_email) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                        placeholder="{{ auth()->user()->email }}"
                    >
                    <p class="text-sm text-gray-600 mt-1">Leave blank to use your account email</p>
                    @error('notification_email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <hr class="my-6">

                <h2 class="text-2xl font-bold text-gray-900 mb-6">Report Automation</h2>

                <!-- Auto-Generate Reports -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div>
                        <h3 class="font-semibold text-gray-900">Auto-Generate Reports</h3>
                        <p class="text-sm text-gray-600 mt-1">Automatically generate reports on a regular schedule</p>
                    </div>
                    <input 
                        type="checkbox" 
                        name="auto_generate_reports" 
                        value="1"
                        {{ old('auto_generate_reports', $settings->auto_generate_reports) ? 'checked' : '' }}
                        class="w-5 h-5 rounded cursor-pointer"
                    >
                </div>

                <!-- Report Frequency -->
                <div>
                    <label for="report_frequency" class="block text-sm font-medium text-gray-700 mb-1">Report Generation Frequency</label>
                    <select 
                        id="report_frequency" 
                        name="report_frequency"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                    >
                        <option value="weekly" {{ old('report_frequency', $settings->report_frequency) === 'weekly' ? 'selected' : '' }}>Weekly</option>
                        <option value="monthly" {{ old('report_frequency', $settings->report_frequency) === 'monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="quarterly" {{ old('report_frequency', $settings->report_frequency) === 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                    </select>
                    @error('report_frequency') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
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
    </div>
</x-layouts.app>
