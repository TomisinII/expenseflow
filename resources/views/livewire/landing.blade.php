<div>
    {{-- Header --}}
    <livewire:components.header />

    {{-- Hero Section --}}
    <section class="relative bg-gradient-to-br from-indigo-600 via-purple-600 to-indigo-800 text-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-16 py-24 sm:py-32">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                {{-- Left Content --}}
                <div>
                    <h1 class="text-4xl sm:text-5xl lg:text-5xl font-bold leading-tight mb-6">
                        Take Control of Your Finances
                    </h1>
                    <p class="text-xl text-indigo-100 mb-8">
                        Track expenses, set budgets, and understand your spending patterns with ExpenseFlow's intuitive interface
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('register') }}">
                            <x-secondary-button class="px-6 py-3 text-lg">
                                Get Started Free
                            </x-secondary-button>
                        </a>
                        <a href="#how-it-works">
                            <x-primary-button class="px-6 py-3 text-lg">
                                See How It Works
                            </x-primary-button>
                        </a>
                    </div>
                    <p class="mt-6 text-sm text-indigo-200">
                        ✓ No credit card required • ✓ Free • ✓ Takes less than 30 seconds
                    </p>
                </div>

                {{-- Right Content - Dashboard Mockup --}}
                <div class="relative">
                    <div class="bg-white rounded-lg shadow-2xl p-4 transform rotate-2 hover:rotate-0 transition duration-300">
                        <div class="bg-gray-100 rounded-t-lg p-3 flex items-center space-x-2">
                            <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                            <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        </div>
                        <img src="{{ asset('images/dashboard.png') }}"
                             alt="Dashboard Preview"
                             class="w-full rounded-b-lg">
                    </div>
                </div>
            </div>
        </div>

        {{-- Wave Divider --}}
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 0L60 10C120 20 240 40 360 46.7C480 53 600 47 720 43.3C840 40 960 40 1080 46.7C1200 53 1320 67 1380 73.3L1440 80V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0V0Z"
                      fill="#F9FAFB"/>
            </svg>
        </div>
    </section>

    {{-- Features Section --}}
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-16">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">
                    Everything You Need to Manage Your Money
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Powerful features designed to make expense tracking effortless
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Feature 1 --}}
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Smart Expense Tracking</h3>
                    <p class="text-gray-600">Log expenses in seconds with our quick-add form. Categorize automatically and never lose track of where your money goes.</p>
                </div>

                {{-- Feature 2 --}}
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Budget Management</h3>
                    <p class="text-gray-600">Set monthly budgets by category and get real-time alerts when you're approaching your limits.</p>
                </div>

                {{-- Feature 3 --}}
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Visual Analytics</h3>
                    <p class="text-gray-600">Beautiful charts and graphs transform your data into actionable insights about your spending habits.</p>
                </div>

                {{-- Feature 4 --}}
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Category Customization</h3>
                    <p class="text-gray-600">Create custom categories with colors and icons that match your lifestyle and spending patterns.</p>
                </div>

                {{-- Feature 5 --}}
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Multi-Device Access</h3>
                    <p class="text-gray-600">Seamlessly access your expenses from desktop, tablet, or mobile with our fully responsive design.</p>
                </div>

                {{-- Feature 6 --}}
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Dark Mode</h3>
                    <p class="text-gray-600">Easy on the eyes with automatic dark mode support that remembers your preference.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- How It Works Section --}}
    <section id="how-it-works" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-16">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">
                    How It Works
                </h2>
                <p class="text-xl text-gray-600">
                    Get started in minutes, not hours
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                {{-- Step 1 --}}
                <div class="text-center">
                    <div class="w-16 h-16 bg-indigo-600 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">
                        1
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Sign Up</h3>
                    <p class="text-gray-600">Create your free account in under 30 seconds</p>
                </div>

                {{-- Step 2 --}}
                <div class="text-center">
                    <div class="w-16 h-16 bg-indigo-600 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">
                        2
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Add Expenses</h3>
                    <p class="text-gray-600">Log your first expense with amount, category, and date</p>
                </div>

                {{-- Step 3 --}}
                <div class="text-center">
                    <div class="w-16 h-16 bg-indigo-600 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">
                        3
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Set Budgets</h3>
                    <p class="text-gray-600">Define monthly spending limits for each category</p>
                </div>

                {{-- Step 4 --}}
                <div class="text-center">
                    <div class="w-16 h-16 bg-indigo-600 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">
                        4
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Track Progress</h3>
                    <p class="text-gray-600">Watch your spending patterns through intuitive dashboards</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-20 bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-16 text-center">
            <h2 class="text-3xl sm:text-4xl font-bold mb-4">
                Start Tracking Your Expenses Today
            </h2>
            <p class="text-xl text-indigo-100 mb-8">
                Join hundreds of users taking control of their finances
            </p>
            <a href="{{ route('register') }}">
                <x-secondary-button class="px-6 py-3">
                    Create Free Account
                </x-secondary-button>
            </a>
            <p class="mt-6 text-sm text-indigo-200">
                ✓ No credit card required • ✓ Free • ✓ Takes less than 30 seconds
            </p>
        </div>
    </section>

    {{-- FAQ Section --}}
    <section class="py-20 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-16 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">
                    Frequently Asked Questions
                </h2>
                <p class="text-xl text-gray-600">
                    Everything you need to know about ExpenseFlow
                </p>
            </div>

            <div class="space-y-4" x-data="{ openFaq: null }">
                {{-- FAQ 1 --}}
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <button @click="openFaq = openFaq === 1 ? null : 1"
                            class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-900">Is ExpenseFlow really free?</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform"
                             :class="{ 'rotate-180': openFaq === 1 }"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="openFaq === 1"
                         x-collapse
                         class="px-6 pb-4 text-gray-600">
                        Yes! ExpenseFlow is currently free to use. This is a portfolio project demonstrating modern web development practices with Laravel and Livewire. There are no hidden fees or premium tiers at this time.
                    </div>
                </div>

                {{-- FAQ 2 --}}
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <button @click="openFaq = openFaq === 2 ? null : 2"
                            class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-900">Is my financial data secure?</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform"
                             :class="{ 'rotate-180': openFaq === 2 }"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="openFaq === 2"
                         x-collapse
                         class="px-6 pb-4 text-gray-600">
                        Absolutely. All data is encrypted in transit with SSL/HTTPS, stored securely in our database, and never shared with third parties. Only you can access your expense information through your password-protected account.
                    </div>
                </div>

                {{-- FAQ 3 --}}
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <button @click="openFaq = openFaq === 3 ? null : 3"
                            class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-900">Can I export my data?</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform"
                             :class="{ 'rotate-180': openFaq === 3 }"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="openFaq === 3"
                         x-collapse
                         class="px-6 pb-4 text-gray-600">
                        Yes! You can export all your expenses to CSV format at any time. This allows you to analyze your data in spreadsheet applications or import it into other financial tools.
                    </div>
                </div>

                {{-- FAQ 4 --}}
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <button @click="openFaq = openFaq === 4 ? null : 4"
                            class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-900">Does it work on mobile devices?</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform"
                             :class="{ 'rotate-180': openFaq === 4 }"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="openFaq === 4"
                         x-collapse
                         class="px-6 pb-4 text-gray-600">
                        ExpenseFlow is fully responsive and works seamlessly on mobile devices, tablets, and desktops. You can access your expenses from any device with a web browser - no app download required.
                    </div>
                </div>

                {{-- FAQ 5 --}}
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <button @click="openFaq = openFaq === 5 ? null : 5"
                            class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-900">Can I create custom categories?</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform"
                             :class="{ 'rotate-180': openFaq === 5 }"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="openFaq === 5"
                         x-collapse
                         class="px-6 pb-4 text-gray-600">
                        Yes! While we provide default categories like Food, Transportation, and Entertainment, you can create unlimited custom categories with your own colors and icons to match your lifestyle and spending patterns.
                    </div>
                </div>

                {{-- FAQ 6 --}}
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <button @click="openFaq = openFaq === 6 ? null : 6"
                            class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-900">How do budget alerts work?</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform"
                             :class="{ 'rotate-180': openFaq === 6 }"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="openFaq === 6"
                         x-collapse
                         class="px-6 pb-4 text-gray-600">
                        Set a monthly budget for any category, and ExpenseFlow will automatically track your spending. You'll see visual progress bars and receive alerts when you reach 90% of your budget and when you exceed it.
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                {{-- Brand --}}
                <div class="col-span-1">
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-xl">E</span>
                        </div>
                        <span class="text-xl font-bold text-white">ExpenseFlow</span>
                    </div>
                    <p class="text-sm">
                        Built using Laravel & Livewire by Olutomisin Oluwajuwon
                    </p>
                </div>

                {{-- Links --}}
                <div>
                    <h4 class="text-white font-semibold mb-4">Product</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">Features</a></li>
                        <li><a href="#" class="hover:text-white">How it works</a></li>
                        <li><a href="#" class="hover:text-white">Pricing</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-4">Company</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">About</a></li>
                        <li><a href="#" class="hover:text-white">Privacy</a></li>
                        <li><a href="#" class="hover:text-white">Terms</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-4">Connect</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">GitHub</a></li>
                        <li><a href="#" class="hover:text-white">Contact</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-sm text-center">
                <p>&copy; {{ date('Y') }} ExpenseFlow. All rights reserved.</p>
            </div>
        </div>
    </footer>
</div>
