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

        <!-- Roles & Permissions Content -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Roles & Permissions Management</h2>
                        <p class="text-gray-600 mt-1">Create and manage user roles with specific permissions</p>
                    </div>
                    <a href="{{ route('roles.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        New Role
                    </a>
                </div>

                <!-- Roles List -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Role Name</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Display Name</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Permissions Count</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($roles as $role)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                            {{ $role->name }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $role->display_name }}</td>
                                    <td class="px-6 py-4 text-gray-600">
                                        <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                            {{ $role->permissions->count() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 space-x-2">
                                        <a href="{{ route('roles.edit', $role) }}" class="inline-flex items-center px-3 py-1 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 text-sm transition">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </a>
                                        @if($role->name !== 'admin')
                                            <form action="{{ route('roles.destroy', $role) }}" method="POST" class="inline" onsubmit="return confirm('Delete this role?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-50 text-red-600 rounded hover:bg-red-100 text-sm transition">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                        <p class="mb-4">No roles found.</p>
                                        <a href="{{ route('roles.create') }}" class="text-blue-600 hover:text-blue-700 font-medium">Create your first role</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Assign Roles Button -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <a href="{{ route('roles.assign-roles') }}" class="inline-flex items-center px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                        Assign Roles to Users
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
