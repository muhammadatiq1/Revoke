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

        <!-- General Settings Form -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Company Information</h2>

            <form action="{{ route('settings.update-general') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Company Name -->
                <div>
                    <label for="company_name" class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
                    <input 
                        type="text" 
                        id="company_name" 
                        name="company_name" 
                        value="{{ old('company_name', $settings->company_name) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                        placeholder="Your company name"
                    >
                    @error('company_name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Company Email -->
                <div>
                    <label for="company_email" class="block text-sm font-medium text-gray-700 mb-1">Company Email</label>
                    <input 
                        type="email" 
                        id="company_email" 
                        name="company_email" 
                        value="{{ old('company_email', $settings->company_email) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                        placeholder="contact@company.com"
                    >
                    @error('company_email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Company Phone -->
                <div>
                    <label for="company_phone" class="block text-sm font-medium text-gray-700 mb-1">Company Phone</label>
                    <input 
                        type="text" 
                        id="company_phone" 
                        name="company_phone" 
                        value="{{ old('company_phone', $settings->company_phone) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                        placeholder="+1 (555) 123-4567"
                    >
                    @error('company_phone') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Company Address -->
                <div>
                    <label for="company_address" class="block text-sm font-medium text-gray-700 mb-1">Company Address</label>
                    <textarea 
                        id="company_address" 
                        name="company_address" 
                        rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none resize-none"
                        placeholder="123 Business Street, City, State 12345"
                    >{{ old('company_address', $settings->company_address) }}</textarea>
                    @error('company_address') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <hr class="my-6">

                <h2 class="text-2xl font-bold text-gray-900 mb-6">Preferences</h2>

                <!-- Timezone -->
                <div>
                    <label for="timezone" class="block text-sm font-medium text-gray-700 mb-1">Timezone</label>
                    <select 
                        id="timezone" 
                        name="timezone"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                    >
                        @foreach(['UTC', 'America/New_York', 'America/Chicago', 'America/Denver', 'America/Los_Angeles', 'Europe/London', 'Europe/Paris', 'Asia/Tokyo', 'Asia/Dubai', 'Australia/Sydney'] as $tz)
                            <option value="{{ $tz }}" {{ old('timezone', $settings->timezone) === $tz ? 'selected' : '' }}>
                                {{ str_replace('_', ' ', $tz) }}
                            </option>
                        @endforeach
                    </select>
                    @error('timezone') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Date Format -->
                <div>
                    <label for="date_format" class="block text-sm font-medium text-gray-700 mb-1">Date Format</label>
                    <select 
                        id="date_format" 
                        name="date_format"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                    >
                        @foreach(['M d, Y', 'd/m/Y', 'Y-m-d', 'm-d-Y'] as $fmt)
                            <option value="{{ $fmt }}" {{ old('date_format', $settings->date_format) === $fmt ? 'selected' : '' }}>
                                {{ $fmt }} (Example: {{ now()->format($fmt) }})
                            </option>
                        @endforeach
                    </select>
                    @error('date_format') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Currency -->
                <div>
                    <label for="currency" class="block text-sm font-medium text-gray-700 mb-1">Currency</label>
                    <select 
                        id="currency" 
                        name="currency"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                    >
                        @foreach(['USD' => 'US Dollar', 'EUR' => 'Euro', 'GBP' => 'British Pound', 'CAD' => 'Canadian Dollar', 'AUD' => 'Australian Dollar', 'JPY' => 'Japanese Yen'] as $code => $name)
                            <option value="{{ $code }}" {{ old('currency', $settings->currency) === $code ? 'selected' : '' }}>
                                {{ $name }} ({{ $code }})
                            </option>
                        @endforeach
                    </select>
                    @error('currency') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
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
