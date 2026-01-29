@extends('layouts.app')

@section('content')
<div class="mb-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('roles.index') }}" class="text-blue-600 hover:text-blue-700 flex items-center mb-4">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Roles
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Create New Role</h1>
            <p class="text-gray-600 mt-2">Define a new role and assign permissions</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow">
            <form action="{{ route('roles.store') }}" method="POST" class="p-6 space-y-6">
                @csrf

                <!-- Role Name -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Role Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="e.g., content_manager" required>
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Display Name -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Display Name *</label>
                    <input type="text" name="display_name" value="{{ old('display_name') }}" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="e.g., Content Manager" required>
                    @error('display_name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Description</label>
                    <textarea name="description" rows="3" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Brief description of this role's purpose"></textarea>
                    @error('description')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Permissions by Module -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-4">Permissions</label>
                    <div class="space-y-6">
                        @foreach($modules as $module => $permissions)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center mb-4">
                                    <input type="checkbox" id="select-all-{{ str_replace(' ', '-', strtolower($module)) }}" 
                                        class="module-select-all w-4 h-4 text-blue-600 rounded" 
                                        data-module="{{ $module }}">
                                    <label class="ml-3 font-semibold text-gray-900">{{ $module ?? 'General' }}</label>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    @foreach($permissions as $permission)
                                        <label class="flex items-center">
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                                                class="module-checkbox w-4 h-4 text-blue-600 rounded" 
                                                data-module="{{ $permission->module }}">
                                            <span class="ml-3 text-gray-700">{{ $permission->display_name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex gap-3 pt-6 border-t border-gray-200">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Create Role
                    </button>
                    <a href="{{ route('roles.index') }}" class="px-6 py-2 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.querySelectorAll('.module-select-all').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const module = this.dataset.module;
                document.querySelectorAll(`.module-checkbox[data-module="${module}"]`).forEach(cb => {
                    cb.checked = this.checked;
                });
            });
        });
    </script>
@endsection
