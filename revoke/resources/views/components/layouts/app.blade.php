<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Revoke - Executive Dashboard</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">
        <!-- Backdrop Overlay for Mobile -->
        <div @click="sidebarOpen = false" x-show="sidebarOpen" class="fixed inset-0 bg-black/40 z-40 lg:hidden backdrop-blur-sm" x-transition:enter="transition ease-out duration-200" x-transition:leave="transition ease-in duration-150"></div>

        <!-- Minimal Sidebar - Navy Blue Theme -->
        <aside class="h-screen bg-gradient-to-b from-blue-900 to-blue-800 border-r border-blue-700 flex flex-col py-6 transition-all duration-500 ease-out z-50 overflow-y-auto shadow-2xl" :class="{ 'w-72': sidebarOpen, 'w-20': !sidebarOpen }">
            <!-- Header with Logo and Close Button -->
            <div class="flex items-center justify-between px-4 mb-10 flex-shrink-0">
                <a href="/" class="text-white font-black text-2xl hover:text-blue-300 transition-colors duration-300 flex items-center gap-3 flex-shrink-0">
                    <span class="flex-shrink-0 text-3xl">✈</span>
                    <span class="text-lg font-bold whitespace-nowrap" x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300" x-transition:leave="transition ease-in duration-200">Revoke</span>
                </a>
                <!-- Toggle Button on Sidebar -->
                <button @click="sidebarOpen = !sidebarOpen" x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300" x-transition:leave="transition ease-in duration-200" class="p-2 hover:bg-red-500/20 rounded-lg transition-all duration-300 text-red-300 hover:text-red-200 flex-shrink-0 group">
                    <svg class="w-5 h-5 group-hover:scale-125 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Navigation Icons with Labels - Premium -->
            <nav class="flex flex-col space-y-1 px-3 flex-1">
                <a href="{{ route('dashboard') }}" class="p-3 rounded-xl {{ request()->routeIs('dashboard') ? 'bg-blue-500/20 text-blue-200 shadow-lg border border-blue-500/30' : 'text-blue-200 hover:text-blue-100 hover:bg-blue-700/50' }} transition-all duration-300 flex items-center gap-4 group whitespace-nowrap">
                    <svg class="w-6 h-6 flex-shrink-0 group-hover:scale-125 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 5h6m-6 4h6m3-7h.01M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path>
                    </svg>
                    <span class="font-semibold text-sm tracking-wide" x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300" x-transition:leave="transition ease-in duration-200">Dashboard</span>
                </a>
                <a href="{{ route('employees.index') }}" class="p-3 rounded-xl {{ request()->routeIs('employees.*') ? 'bg-blue-500/20 text-blue-200 shadow-lg border border-blue-500/30' : 'text-blue-200 hover:text-blue-100 hover:bg-blue-700/50' }} transition-all duration-300 flex items-center gap-4 group whitespace-nowrap">
                    <svg class="w-6 h-6 flex-shrink-0 group-hover:scale-125 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM12 14a6 6 0 00-6 6v2h12v-2a6 6 0 00-6-6z"></path>
                    </svg>
                    <span class="font-semibold text-sm tracking-wide" x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300" x-transition:leave="transition ease-in duration-200">Employees</span>
                </a>
                <a href="{{ route('softwares.index') }}" class="p-3 rounded-xl {{ request()->routeIs('softwares.*') ? 'bg-blue-500/20 text-blue-200 shadow-lg border border-blue-500/30' : 'text-blue-200 hover:text-blue-100 hover:bg-blue-700/50' }} transition-all duration-300 flex items-center gap-4 group whitespace-nowrap">
                    <svg class="w-6 h-6 flex-shrink-0 group-hover:scale-125 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m0 10v10l8 4m0-10l8-4"></path>
                    </svg>
                    <span class="font-semibold text-sm tracking-wide" x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300" x-transition:leave="transition ease-in duration-200">Software</span>
                </a>
                <a href="{{ route('offboarding.index') }}" class="p-3 rounded-xl {{ request()->routeIs('offboarding.*') ? 'bg-blue-500/20 text-blue-200 shadow-lg border border-blue-500/30' : 'text-blue-200 hover:text-blue-100 hover:bg-blue-700/50' }} transition-all duration-300 flex items-center gap-4 group whitespace-nowrap">
                    <svg class="w-6 h-6 flex-shrink-0 group-hover:scale-125 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="font-semibold text-sm tracking-wide" x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300" x-transition:leave="transition ease-in duration-200">Offboarding</span>
                </a>
                <a href="{{ route('reports.index') }}" class="p-3 rounded-xl {{ request()->routeIs('reports.*') ? 'bg-blue-500/20 text-blue-200 shadow-lg border border-blue-500/30' : 'text-blue-200 hover:text-blue-100 hover:bg-blue-700/50' }} transition-all duration-300 flex items-center gap-4 group whitespace-nowrap">
                    <svg class="w-6 h-6 flex-shrink-0 group-hover:scale-125 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span class="font-semibold text-sm tracking-wide" x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300" x-transition:leave="transition ease-in duration-200">Reports</span>
                </a>
                <a href="{{ route('settings.general') }}" class="p-3 rounded-xl {{ request()->routeIs('settings.*') ? 'bg-blue-500/20 text-blue-200 shadow-lg border border-blue-500/30' : 'text-blue-200 hover:text-blue-100 hover:bg-blue-700/50' }} transition-all duration-300 flex items-center gap-4 group whitespace-nowrap">
                    <svg class="w-6 h-6 flex-shrink-0 group-hover:scale-125 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="font-semibold text-sm tracking-wide" x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300" x-transition:leave="transition ease-in duration-200">Settings</span>
                </a>
            </nav>

            <!-- Bottom Section - Premium -->
            <div class="w-full px-3 border-t border-blue-700 pt-4 flex-shrink-0" x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300" x-transition:leave="transition ease-in duration-200">
                <div class="bg-blue-500/20 rounded-xl p-4 border border-blue-500/30 shadow-lg">
                    <p class="text-xs font-bold text-blue-200 uppercase tracking-widest">System</p>
                    <p class="text-xs text-blue-100 mt-2">Shadow IT Management</p>
                    <p class="text-xs text-blue-300 mt-2 font-semibold">v1.0 Professional</p>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header with Premium Design -->
            <header class="bg-gradient-to-r from-blue-900 via-blue-800 to-blue-900 border-b border-blue-700 px-8 py-5 flex items-center justify-between shadow-2xl backdrop-blur-md sticky top-0 z-40">
                <!-- Left: Hamburger + Title -->
                <div class="flex items-center gap-6">
                    <button @click="sidebarOpen = !sidebarOpen" class="p-2.5 hover:bg-blue-500/20 rounded-xl transition-all duration-300 text-blue-300 hover:text-blue-200 hover:shadow-lg hover:shadow-blue-500/20 group active:scale-95">
                        <svg class="w-6 h-6 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <div>
                        <h1 class="text-2xl font-black text-white tracking-tight">{{ $title ?? 'Executive Dashboard' }}</h1>
                        <p class="text-xs text-blue-200 mt-1 font-medium">Shadow IT Management System</p>
                    </div>
                </div>

                <!-- Right: Notifications & Profile -->
                <div class="flex items-center gap-8">
                    <!-- Search - Hidden on Mobile -->
                    <div class="hidden lg:flex items-center bg-blue-800/50 rounded-xl px-4 py-2.5 border border-blue-600 hover:border-blue-500 transition-all duration-300 focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500/20">
                        <svg class="w-5 h-5 text-blue-300 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="search" placeholder="Search..." class="bg-transparent text-white text-sm placeholder-blue-300 outline-none w-48">
                    </div>

                    <!-- Notifications -->
                    <button class="p-2.5 hover:bg-blue-800/50 rounded-xl transition-all duration-300 text-blue-300 hover:text-blue-200 relative group">
                        <svg class="w-6 h-6 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <span class="absolute top-1 right-1 w-3 h-3 bg-red-500 rounded-full shadow-lg animate-pulse"></span>
                    </button>

                    <!-- Settings -->
                    <button class="p-2.5 hover:bg-blue-800/50 rounded-xl transition-all duration-300 text-blue-300 hover:text-blue-200 group">
                        <svg class="w-6 h-6 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </button>

                    <!-- Divider -->
                    <div class="h-8 w-px bg-gradient-to-b from-blue-600 via-blue-600 to-transparent"></div>

                    <!-- User Profile -->
                    <div class="flex items-center gap-4 pl-4">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-semibold text-white">Admin User</p>
                            <p class="text-xs text-blue-200 font-medium">System Administrator</p>
                        </div>
                        <button class="w-11 h-11 rounded-xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold shadow-lg shadow-blue-500/50 hover:shadow-blue-500/75 transition-all duration-300 hover:scale-105 active:scale-95">
                            A
                        </button>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-auto bg-gradient-to-b from-gray-50 via-gray-50 to-gray-100">
                <div class="px-8 py-8">
                    <div class="backdrop-blur-sm">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
    </div>

</body>
</html>

