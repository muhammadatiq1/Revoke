<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Revoke - Shadow IT & Offboarding Manager</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white">
    <div class="min-h-screen flex" x-data="{ sidebarOpen: true }">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 shadow-sm">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-blue-900">Revoke</h1>
                <p class="text-xs text-blue-600 mt-1">Shadow IT Manager</p>
            </div>

            <nav class="mt-8 px-4 space-y-2">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-blue-700 rounded-lg hover:bg-blue-50 transition duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-100 text-blue-900 border-l-4 border-blue-600' : '' }}">
                    <svg class="w-5 h-5 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m2-2l6.414-6.414a2 2 0 012.828 0L19 5m-15 14h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>

                <a href="{{ route('employees.index') }}" class="flex items-center px-4 py-3 text-blue-700 rounded-lg hover:bg-blue-50 transition duration-200 {{ request()->routeIs('employees.*') ? 'bg-blue-100 text-blue-900 border-l-4 border-blue-600' : '' }}">
                    <svg class="w-5 h-5 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 12H9m6 0a6 6 0 11-12 0 6 6 0 0112 0z"></path>
                    </svg>
                    <span class="font-medium">Employees</span>
                </a>

                <a href="{{ route('softwares.index') }}" class="flex items-center px-4 py-3 text-blue-700 rounded-lg hover:bg-blue-50 transition duration-200 {{ request()->routeIs('softwares.*') ? 'bg-blue-100 text-blue-900 border-l-4 border-blue-600' : '' }}">
                    <svg class="w-5 h-5 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-medium">Applications</span>
                </a>

                <a href="{{ route('offboarding.index') }}" class="flex items-center px-4 py-3 text-blue-700 rounded-lg hover:bg-blue-50 transition duration-200 {{ request()->routeIs('offboarding.*') ? 'bg-blue-100 text-blue-900 border-l-4 border-blue-600' : '' }}">
                    <svg class="w-5 h-5 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-medium">Offboarding</span>
                    @php
                        $pendingCount = \App\Models\OffboardingTask::where('status', 'pending')->count();
                    @endphp
                    @if($pendingCount > 0)
                        <span class="ml-auto inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">
                            {{ $pendingCount }}
                        </span>
                    @endif
                </a>

                <a href="{{ route('reports.index') }}" class="flex items-center px-4 py-3 text-blue-700 rounded-lg hover:bg-blue-50 transition duration-200 {{ request()->routeIs('reports.*') ? 'bg-blue-100 text-blue-900 border-l-4 border-blue-600' : '' }}">
                    <svg class="w-5 h-5 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span class="font-medium">Reports</span>
                </a>

                <hr class="my-4 border-gray-200">

                <a href="{{ route('roles.index') }}" class="flex items-center px-4 py-3 text-blue-700 rounded-lg hover:bg-blue-50 transition duration-200 {{ request()->routeIs('roles.*') ? 'bg-blue-100 text-blue-900 border-l-4 border-blue-600' : '' }}">
                    <svg class="w-5 h-5 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                    </svg>
                    <span class="font-medium">Roles & Permissions</span>
                </a>

                <a href="{{ route('settings.general') }}" class="flex items-center px-4 py-3 text-blue-700 rounded-lg hover:bg-blue-50 transition duration-200 {{ request()->routeIs('settings.*') ? 'bg-blue-100 text-blue-900 border-l-4 border-blue-600' : '' }}">
                    <svg class="w-5 h-5 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="font-medium">Settings</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col bg-gray-50">
            <!-- Top Navigation -->
            <header class="bg-white border-b border-gray-200 shadow-sm">
                <div class="flex items-center justify-between px-8 py-4">
                    <div class="flex items-center flex-1">
                        <div class="w-full max-w-md">
                            <div class="relative">
                                <input type="text" placeholder="Search employees, apps, tasks..." class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50 text-gray-900 placeholder-gray-500">
                                <svg class="absolute right-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- User Profile Dropdown -->
                    <div class="ml-8 flex items-center relative">
                        <button onclick="document.getElementById('userDropdown').classList.toggle('hidden'); return false;" type="button" class="flex items-center space-x-2 text-gray-700 hover:text-blue-900 hover:bg-gray-100 focus:outline-none transition duration-200 px-3 py-2 rounded-lg cursor-pointer">
                            @if(auth()->user()->profile_image)
                                <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="{{ auth()->user()->name }}" class="w-10 h-10 rounded-full border-2 border-blue-400 object-cover">
                            @else
                                <div class="w-10 h-10 rounded-full border-2 border-blue-400 bg-blue-100 flex items-center justify-center">
                                    <span class="text-blue-600 font-medium text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <span class="hidden md:inline-block font-medium text-gray-700">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="userDropdown" class="hidden absolute right-0 top-16 w-56 bg-white rounded-lg shadow-2xl z-50 border border-gray-200">
                            <!-- User Info Section -->
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                            </div>
                            
                            <!-- Menu Items -->
                            <a href="{{ route('settings.profile') }}" onclick="document.getElementById('userDropdown').classList.add('hidden');" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 text-sm font-medium transition duration-150 cursor-pointer">
                                <svg class="w-4 h-4 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span>Settings</span>
                            </a>
                            
                            <hr class="my-1">
                            
                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit" onclick="document.getElementById('userDropdown').classList.add('hidden');" class="w-full flex items-center px-4 py-3 text-gray-700 hover:bg-red-50 text-sm font-medium transition duration-150 cursor-pointer">
                                    <svg class="w-4 h-4 mr-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <script>
                        // Close dropdown when clicking outside
                        document.addEventListener('click', function(e) {
                            const dropdown = document.getElementById('userDropdown');
                            const btn = e.target.closest('button');
                            if (dropdown && !dropdown.contains(e.target) && !btn?.textContent?.includes('{{ auth()->user()->name }}')) {
                                dropdown.classList.add('hidden');
                            }
                        });
                    </script>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-auto">
                <div class="px-8 py-6">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

</body>
</html>
