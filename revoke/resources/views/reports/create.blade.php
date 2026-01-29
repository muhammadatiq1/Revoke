<x-layouts.app>
    <div class="space-y-6">
        <!-- Header -->
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Generate Report</h1>
            <p class="text-gray-600 mt-1">Select a report type to generate insights</p>
        </div>

        <!-- Report Options Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Offboarding Report -->
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition duration-200">
                <div class="p-6">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Offboarding Report</h3>
                    <p class="text-gray-600 text-sm mb-4">Track employee offboarding activities and access revocation metrics</p>
                    <button @click="$dispatch('open-modal', { name: 'offboarding-modal' })" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium text-sm">
                        Generate Report
                    </button>
                </div>
            </div>

            <!-- Software Audit Report -->
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition duration-200">
                <div class="p-6">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-green-100 rounded-lg mb-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Software Audit Report</h3>
                    <p class="text-gray-600 text-sm mb-4">Analyze application costs, usage, and risk levels across your organization</p>
                    <button @click="$dispatch('open-modal', { name: 'software-modal' })" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium text-sm">
                        Generate Report
                    </button>
                </div>
            </div>

            <!-- Risk Assessment Report -->
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition duration-200">
                <div class="p-6">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-red-100 rounded-lg mb-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Risk Assessment Report</h3>
                    <p class="text-gray-600 text-sm mb-4">Identify high-risk applications and employee exposure to critical systems</p>
                    <button @click="$dispatch('open-modal', { name: 'risk-modal' })" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium text-sm">
                        Generate Report
                    </button>
                </div>
            </div>
        </div>

        <!-- Offboarding Report Modal -->
        <div x-show="$store.modals['offboarding-modal']" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
            <div class="bg-white rounded-lg shadow-xl p-6 max-w-md w-full mx-4">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Offboarding Report</h2>
                <form action="{{ route('reports.offboarding') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="offboarding_date_from" class="block text-sm font-medium text-gray-700 mb-1">Date From (Optional)</label>
                            <input type="date" id="offboarding_date_from" name="date_from" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                        </div>
                        <div>
                            <label for="offboarding_date_to" class="block text-sm font-medium text-gray-700 mb-1">Date To (Optional)</label>
                            <input type="date" id="offboarding_date_to" name="date_to" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                        </div>
                    </div>
                    <div class="mt-6 flex gap-3">
                        <button type="button" @click="$dispatch('close-modal', { name: 'offboarding-modal' })" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                            Generate
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Software Audit Report Modal -->
        <div x-show="$store.modals['software-modal']" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
            <div class="bg-white rounded-lg shadow-xl p-6 max-w-md w-full mx-4">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Software Audit Report</h2>
                <form action="{{ route('reports.software-audit') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="risk_level" class="block text-sm font-medium text-gray-700 mb-1">Risk Level (Optional)</label>
                            <select id="risk_level" name="risk_level" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none">
                                <option value="">All Risk Levels</option>
                                <option value="low">Low Risk</option>
                                <option value="high">High Risk</option>
                            </select>
                        </div>
                        <div>
                            <label for="min_cost" class="block text-sm font-medium text-gray-700 mb-1">Minimum Monthly Cost (Optional)</label>
                            <input type="number" id="min_cost" name="min_cost" min="0" step="0.01" placeholder="e.g., 100" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none">
                        </div>
                    </div>
                    <div class="mt-6 flex gap-3">
                        <button type="button" @click="$dispatch('close-modal', { name: 'software-modal' })" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                            Generate
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Risk Assessment Report Modal -->
        <div x-show="$store.modals['risk-modal']" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
            <div class="bg-white rounded-lg shadow-xl p-6 max-w-md w-full mx-4">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Risk Assessment Report</h2>
                <p class="text-gray-600 mb-4">This report analyzes all high-risk applications and employee exposure. No additional parameters needed.</p>
                <form action="{{ route('reports.risk-assessment') }}" method="POST">
                    @csrf
                    <div class="flex gap-3">
                        <button type="button" @click="$dispatch('close-modal', { name: 'risk-modal' })" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                            Generate
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Backdrop Click Handler -->
        <div @click="Object.keys($store.modals).forEach(key => $dispatch('close-modal', { name: key }))" class="fixed inset-0 z-40" x-show="Object.values($store.modals).includes(true)" style="display: none;"></div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('modals', {
                'offboarding-modal': false,
                'software-modal': false,
                'risk-modal': false,
            });
        });

        document.addEventListener('open-modal', (e) => {
            Alpine.store('modals')[e.detail.name] = true;
        });

        document.addEventListener('close-modal', (e) => {
            Alpine.store('modals')[e.detail.name] = false;
        });
    </script>
</x-layouts.app>
