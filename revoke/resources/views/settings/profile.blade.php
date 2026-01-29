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

        <!-- Profile Information -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Profile Information</h2>

            <form action="{{ route('settings.update-profile') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Full Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', $user->name) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                        placeholder="Your full name"
                    >
                    @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email', $user->email) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                        placeholder="your@email.com"
                    >
                    @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Company -->
                <div>
                    <label for="company" class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
                    <input 
                        type="text" 
                        id="company" 
                        name="company" 
                        value="{{ old('company', $user->company) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                        placeholder="Your company"
                    >
                    @error('company') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Profile Image -->
                <div x-data="{ 
                    previewImage: '{{ $user->profile_image ? asset('storage/' . $user->profile_image) : '' }}',
                    previewExists: {{ $user->profile_image ? 'true' : 'false' }}
                }">
                    <label for="profile_image" class="block text-sm font-medium text-gray-700 mb-1">Profile Picture</label>
                    <div class="flex gap-6">
                        <div class="flex-1">
                            <input 
                                type="file" 
                                id="profile_image" 
                                name="profile_image"
                                accept="image/jpeg,image/png,image/jpg,image/gif"
                                @change="
                                    const file = $event.target.files[0];
                                    if (file) {
                                        const reader = new FileReader();
                                        reader.onload = (e) => {
                                            previewImage = e.target.result;
                                            previewExists = true;
                                        };
                                        reader.readAsDataURL(file);
                                    }
                                "
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none file:mr-3 file:py-1 file:px-3 file:bg-blue-50 file:text-blue-600 file:rounded file:border-0 file:cursor-pointer hover:file:bg-blue-100"
                            >
                            <p class="text-sm text-gray-600 mt-1">Max 2MB. Formats: JPEG, PNG, JPG, GIF</p>
                            @error('profile_image') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div x-show="previewExists" class="flex flex-col items-center">
                            <p class="text-sm text-gray-700 mb-3 font-medium">Preview</p>
                            <img 
                                :src="previewImage"
                                alt="Profile preview"
                                class="w-24 h-24 rounded-lg object-cover border border-gray-200 shadow-sm"
                            >
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex gap-3 pt-4">
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                        Update Profile
                    </button>
                    <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Change Password -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Change Password</h2>

            <form action="{{ route('settings.update-password') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Current Password -->
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                    <input 
                        type="password" 
                        id="current_password" 
                        name="current_password" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                        placeholder="Enter your current password"
                    >
                    @error('current_password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- New Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                        placeholder="Enter new password"
                    >
                    <p class="text-sm text-gray-600 mt-1">Must be at least 8 characters long</p>
                    @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                        placeholder="Confirm new password"
                    >
                    @error('password_confirmation') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex gap-3 pt-4">
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                        Change Password
                    </button>
                    <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Account Info -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Account Information</h2>
            <div class="space-y-3">
                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                    <span class="text-gray-600">Account Created</span>
                    <span class="font-medium text-gray-900">{{ $user->created_at->format('M d, Y H:i') }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                    <span class="text-gray-600">Last Updated</span>
                    <span class="font-medium text-gray-900">{{ $user->updated_at->format('M d, Y H:i') }}</span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span class="text-gray-600">Account Status</span>
                    <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
