<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revoke - Shadow IT & Offboarding Manager</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .gradient-blue {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }
        .gradient-dark {
            background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
        }
    </style>
</head>
<body class="font-sans antialiased bg-white">
    <!-- Navigation -->
    <nav class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold text-lg">R</span>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-blue-900">Revoke</h1>
                    <p class="text-xs text-blue-600">Shadow IT Manager</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                @if(auth()->check())
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 font-medium">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-blue-600 hover:text-blue-900 font-medium">Login</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 font-medium">Register</a>
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="gradient-blue text-white py-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-5xl font-bold mb-6 leading-tight">Manage Shadow IT & Employee Offboarding with Ease</h2>
                    <p class="text-xl text-blue-100 mb-8">Revoke gives you complete visibility and control over unauthorized software, manage employee offboarding workflows, and maintain robust security policies.</p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        @if(!auth()->check())
                            <a href="{{ route('register') }}" class="px-6 py-3 bg-white text-blue-600 rounded-lg hover:bg-gray-100 transition duration-200 font-bold text-center">Get Started Free</a>
                            <a href="{{ route('login') }}" class="px-6 py-3 border-2 border-white text-white rounded-lg hover:bg-blue-700 transition duration-200 font-bold text-center">Sign In</a>
                        @else
                            <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-white text-blue-600 rounded-lg hover:bg-gray-100 transition duration-200 font-bold text-center">Go to Dashboard</a>
                        @endif
                    </div>
                </div>
                <div>
                    <div class="gradient-dark rounded-lg p-8 text-white">
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold">Full Control</p>
                                    <p class="text-sm text-gray-300">Manage all systems centrally</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold">Real-time Updates</p>
                                    <p class="text-sm text-gray-300">Instant alerts & notifications</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold">Secure & Compliant</p>
                                    <p class="text-sm text-gray-300">Enterprise-grade security</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h3 class="text-4xl font-bold text-gray-900 mb-4">Powerful Features</h3>
                <p class="text-xl text-gray-600">Everything you need to manage Shadow IT and offboarding</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white rounded-lg p-8 shadow-md hover:shadow-lg transition duration-300">
                    <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 12H9m6 0a6 6 0 11-12 0 6 6 0 0112 0z"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">Employee Management</h4>
                    <p class="text-gray-600">Efficiently manage employee profiles, track software assignments, and monitor permissions across your organization.</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white rounded-lg p-8 shadow-md hover:shadow-lg transition duration-300">
                    <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">Software Registry</h4>
                    <p class="text-gray-600">Maintain a comprehensive database of approved and unapproved applications with full control over software deployment and licensing.</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white rounded-lg p-8 shadow-md hover:shadow-lg transition duration-300">
                    <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">Offboarding Workflow</h4>
                    <p class="text-gray-600">Automate employee offboarding with structured workflows, ensure proper software revocation, and maintain audit trails.</p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-white rounded-lg p-8 shadow-md hover:shadow-lg transition duration-300">
                    <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">Advanced Analytics</h4>
                    <p class="text-gray-600">Generate detailed reports on software usage, employee compliance, and security risks across your organization.</p>
                </div>

                <!-- Feature 5 -->
                <div class="bg-white rounded-lg p-8 shadow-md hover:shadow-lg transition duration-300">
                    <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">Role-Based Access</h4>
                    <p class="text-gray-600">Control user permissions with granular role-based access control (RBAC) for maximum security and compliance.</p>
                </div>

                <!-- Feature 6 -->
                <div class="bg-white rounded-lg p-8 shadow-md hover:shadow-lg transition duration-300">
                    <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">Customizable Settings</h4>
                    <p class="text-gray-600">Tailor the system to your organization with flexible configuration options and notification preferences.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="gradient-blue text-white py-16">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-8 text-center">
                <div>
                    <p class="text-4xl font-bold mb-2">1000+</p>
                    <p class="text-blue-100">Organizations</p>
                </div>
                <div>
                    <p class="text-4xl font-bold mb-2">50K+</p>
                    <p class="text-blue-100">Employees Managed</p>
                </div>
                <div>
                    <p class="text-4xl font-bold mb-2">99.9%</p>
                    <p class="text-blue-100">Uptime</p>
                </div>
                <div>
                    <p class="text-4xl font-bold mb-2">24/7</p>
                    <p class="text-blue-100">Support</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h3 class="text-4xl font-bold text-gray-900 mb-6">Ready to Take Control?</h3>
            <p class="text-xl text-gray-600 mb-8">Start managing Shadow IT and streamline your offboarding process today. No credit card required.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @if(!auth()->check())
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 font-bold text-lg">Start Free Trial</a>
                    <a href="{{ route('login') }}" class="px-8 py-4 border-2 border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition duration-200 font-bold text-lg">Sign In</a>
                @else
                    <a href="{{ route('dashboard') }}" class="px-8 py-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 font-bold text-lg">Open Dashboard</a>
                @endif
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h5 class="font-bold text-white mb-4">Revoke</h5>
                    <p class="text-sm">Shadow IT & Offboarding Manager</p>
                </div>
                <div>
                    <h5 class="font-bold text-white mb-4">Product</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition">Features</a></li>
                        <li><a href="#" class="hover:text-white transition">Security</a></li>
                        <li><a href="#" class="hover:text-white transition">Pricing</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-bold text-white mb-4">Company</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition">About</a></li>
                        <li><a href="#" class="hover:text-white transition">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition">Careers</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-bold text-white mb-4">Legal</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition">Privacy</a></li>
                        <li><a href="#" class="hover:text-white transition">Terms</a></li>
                        <li><a href="#" class="hover:text-white transition">Contact</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-sm">
                <p>&copy; 2026 Revoke. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
