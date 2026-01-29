@extends('layouts.app')

@section('content')
<div class="mb-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <a href="{{ route('roles.index') }}" class="text-blue-600 hover:text-blue-700 flex items-center mb-4">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Roles
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Assign Roles to Users</h1>
                <p class="text-gray-600 mt-2">Select users and assign one or more roles</p>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-green-800">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Users Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">User Name</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Current Roles</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Assign Roles</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-gray-600 text-sm">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @forelse($user->roles as $role)
                                            <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                                                {{ $role->display_name }}
                                            </span>
                                        @empty
                                            <span class="text-gray-500 text-sm">No roles assigned</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <button onclick="openRoleModal({{ $user->id }}, '{{ $user->name }}')" 
                                        class="inline-flex items-center px-3 py-1 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 text-sm">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Manage Roles
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                    No users found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Role Assignment Modal -->
    <div id="roleModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full mx-4">
            <div class="p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Assign Roles to <span id="userName"></span></h2>
                
                <form id="roleForm" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="space-y-3 max-h-96 overflow-y-auto">
                        @foreach($roles as $role)
                            <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                                <input type="checkbox" name="roles[]" value="{{ $role->id }}" 
                                    class="w-4 h-4 text-blue-600 rounded">
                                <div class="ml-3">
                                    <p class="font-semibold text-gray-900">{{ $role->display_name }}</p>
                                    <p class="text-xs text-gray-600">{{ $role->description }}</p>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    <div class="flex gap-3 pt-4 border-t border-gray-200">
                        <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Save Roles
                        </button>
                        <button type="button" onclick="closeRoleModal()" class="flex-1 px-4 py-2 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openRoleModal(userId, userName) {
            document.getElementById('userName').textContent = userName;
            document.getElementById('roleForm').action = `/users/${userId}/roles`;
            
            // Uncheck all checkboxes first
            document.querySelectorAll('#roleForm input[type="checkbox"]').forEach(cb => cb.checked = false);
            
            // Fetch user's current roles (would need API endpoint or fetch from data attribute)
            document.getElementById('roleModal').classList.remove('hidden');
        }

        function closeRoleModal() {
            document.getElementById('roleModal').classList.add('hidden');
        }

        // Close modal on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeRoleModal();
            }
        });
    </script>
@endsection
