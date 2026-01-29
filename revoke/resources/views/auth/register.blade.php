<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Revoke - Create Account</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 h-screen flex items-center justify-center overflow-y-auto py-8" x-data="{ showPassword: false, showConfirmPassword: false }">
    <div class="w-full max-w-md mx-auto px-4">
        <!-- Register Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Header Section - Navy Blue -->
            <div class="bg-gradient-to-r from-blue-900 to-blue-800 px-8 py-12 text-center">
                <!-- Logo -->
                <div class="mb-4">
                    <svg class="w-12 h-12 mx-auto text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-white mb-2">Create Account</h1>
                <p class="text-blue-100 text-sm font-medium">Join Revoke Shadow IT System</p>
            </div>

            <!-- Form Section - White -->
            <div class="px-8 py-8">
                <!-- Register Form -->
                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- Full Name Field -->
                    <div>
                        <label for="name" class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">Full Name</label>
                        <div class="relative">
                            <input 
                                type="text" 
                                name="name" 
                                id="name"
                                value="{{ old('name') }}"
                                required 
                                autocomplete="name"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-300 text-gray-900 placeholder-gray-500 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:bg-white transition-all duration-300 outline-none font-medium text-sm"
                                placeholder="John Doe"
                            >
                            <svg class="absolute right-4 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">Email Address</label>
                        <div class="relative">
                            <input 
                                type="email" 
                                name="email" 
                                id="email"
                                value="{{ old('email') }}"
                                required 
                                autocomplete="email"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-300 text-gray-900 placeholder-gray-500 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:bg-white transition-all duration-300 outline-none font-medium text-sm"
                                placeholder="john@example.com"
                            >
                            <svg class="absolute right-4 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Company Field -->
                    <div>
                        <label for="company" class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">Company</label>
                        <div class="relative">
                            <input 
                                type="text" 
                                name="company" 
                                id="company"
                                value="{{ old('company') }}"
                                required 
                                autocomplete="organization"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-300 text-gray-900 placeholder-gray-500 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:bg-white transition-all duration-300 outline-none font-medium text-sm"
                                placeholder="Your Company"
                            >
                            <svg class="absolute right-4 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        @error('company')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">Password</label>
                        <div class="relative">
                            <input 
                                :type="showPassword ? 'text' : 'password'" 
                                name="password" 
                                id="password"
                                required 
                                autocomplete="new-password"
                                class="w-full px-4 py-3 pr-12 bg-gray-50 border border-gray-300 text-gray-900 placeholder-gray-500 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:bg-white transition-all duration-300 outline-none font-medium text-sm"
                                placeholder="••••••••••••"
                            >
                            <button 
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute right-4 top-3.5 text-gray-400 hover:text-gray-600 transition-colors duration-300"
                            >
                                <svg v-if="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-4.803m5.596-3.856a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18"></path>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Confirmation Field -->
                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">Confirm Password</label>
                        <div class="relative">
                            <input 
                                :type="showConfirmPassword ? 'text' : 'password'" 
                                name="password_confirmation" 
                                id="password_confirmation"
                                required 
                                autocomplete="new-password"
                                class="w-full px-4 py-3 pr-12 bg-gray-50 border border-gray-300 text-gray-900 placeholder-gray-500 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:bg-white transition-all duration-300 outline-none font-medium text-sm"
                                placeholder="••••••••••••"
                            >
                            <button 
                                type="button"
                                @click="showConfirmPassword = !showConfirmPassword"
                                class="absolute right-4 top-3.5 text-gray-400 hover:text-gray-600 transition-colors duration-300"
                            >
                                <svg v-if="!showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-4.803m5.596-3.856a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18"></path>
                                </svg>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Terms Checkbox -->
                    <label class="flex items-start gap-2 cursor-pointer pt-1">
                        <input 
                            type="checkbox" 
                            name="terms"
                            id="terms"
                            required
                            class="w-4 h-4 rounded border border-gray-300 text-blue-600 focus:ring-0 cursor-pointer accent-blue-600 mt-0.5"
                        >
                        <span class="text-xs text-gray-600 font-medium">I agree to the <a href="#" class="text-blue-600 hover:text-blue-700 font-semibold">Terms and Conditions</a></span>
                    </label>

                    <!-- Sign Up Button -->
                    <button 
                        type="submit"
                        class="w-full py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold text-sm rounded-lg transition-all duration-300 shadow-md hover:shadow-lg active:scale-95 mt-6 flex items-center justify-center gap-2"
                    >
                        Create Account
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </button>
                </form>

                <!-- Sign In Link -->
                <div class="mt-6 text-center border-t border-gray-200 pt-6">
                    <p class="text-gray-600 text-xs font-medium">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-bold transition-colors duration-300">
                            Sign in here
                        </a>
                    </p>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-8 py-3 text-center border-t border-gray-200">
                <p class="text-gray-500 text-xs font-medium">© 2026 Revoke. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>

