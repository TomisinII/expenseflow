<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ auth()->user()?->theme === 'dark' ? 'dark' : '' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ExpenseFlow') }} - Dashboard</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div x-data="{
            sidebarOpen: window.innerWidth >= 1024,
            mobileMenuOpen: false,
            toggleSidebar() {
                this.sidebarOpen = !this.sidebarOpen;
            },
            getInitials(name) {
                return name.split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2);
            }
        }"
        @avatar-updated.window="setTimeout(() => window.location.reload(), 500)"
        @resize.window="if (window.innerWidth >= 1024) mobileMenuOpen = false"
        class="min-h-screen bg-gray-50 dark:bg-gray-900">

            {{-- Desktop Sidebar Navigation --}}
            <div class="hidden lg:block">
                <livewire:layout.navigation />
            </div>

            {{-- Mobile Bottom Navigation --}}
            <nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 z-50 safe-area-bottom">
                <div class="grid grid-cols-5 h-16">
                    {{-- Dashboard --}}
                    <a href="{{ route('dashboard') }}"
                       wire:navigate
                       class="flex flex-col items-center justify-center space-y-1 {{ request()->routeIs('dashboard') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-600 dark:text-gray-400' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span class="text-xs font-medium">Dashboard</span>
                    </a>

                    {{-- Expenses --}}
                    <a href="{{ route('expenses.index') }}"
                       wire:navigate
                       class="flex flex-col items-center justify-center space-y-1 {{ request()->routeIs('expenses.*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-600 dark:text-gray-400' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        <span class="text-xs font-medium">Expenses</span>
                    </a>

                    {{-- Categories --}}
                    <a href="{{ route('categories.index') }}"
                       wire:navigate
                       class="flex flex-col items-center justify-center space-y-1 {{ request()->routeIs('categories.*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-600 dark:text-gray-400' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        <span class="text-xs font-medium">Categories</span>
                    </a>

                    {{-- Budgets --}}
                    <a href="{{ route('budgets.index') }}"
                       wire:navigate
                       class="flex flex-col items-center justify-center space-y-1 {{ request()->routeIs('budgets.*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-600 dark:text-gray-400' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-xs font-medium">Budgets</span>
                    </a>

                    {{-- Analytics --}}
                    <a href="{{ route('analytics') }}"
                       wire:navigate
                       class="flex flex-col items-center justify-center space-y-1 {{ request()->routeIs('analytics') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-600 dark:text-gray-400' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <span class="text-xs font-medium">Analytics</span>
                    </a>
                </div>
            </nav>

            {{-- Main Content Area --}}
            <div :class="sidebarOpen ? 'lg:ml-64' : 'lg:ml-20'" class="transition-all duration-300 ease-in-out pb-16 lg:pb-0">
                {{-- Mobile Top Header --}}
                <header class="lg:hidden sticky top-0 z-40 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="px-4 py-3 flex items-center justify-between">
                        {{-- Logo --}}
                        <div class="flex items-center space-x-2">
                            <div class="w-8 h-8 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center">
                                <span class="text-white font-bold text-sm">E</span>
                            </div>
                            <div class="font-bold text-lg">
                                <span class="text-indigo-600 dark:text-indigo-400">Expense</span><span class="text-purple-600 dark:text-purple-400">Flow</span>
                            </div>
                        </div>

                        {{-- Right Actions --}}
                        <div class="flex items-center space-x-3">
                            {{-- Notification Bell --}}
                            <livewire:notification-bell />

                            {{-- Profile Avatar --}}
                            <button @click="mobileMenuOpen = !mobileMenuOpen"
                                    class="relative">
                                @if(auth()->user()->avatar)
                                    <img
                                        src="{{ asset('storage/' . auth()->user()->avatar) }}"
                                        alt="{{ auth()->user()->name }}"
                                        class="w-8 h-8 rounded-full object-cover border-2 border-gray-200 dark:border-gray-600"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="w-8 h-8 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-full flex items-center justify-center" style="display: none;">
                                        <span class="text-white text-xs font-semibold"
                                              x-text="getInitials('{{ auth()->user()->name }}')"></span>
                                    </div>
                                @else
                                    <div class="w-8 h-8 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-full flex items-center justify-center">
                                        <span class="text-white text-xs font-semibold"
                                              x-text="getInitials('{{ auth()->user()->name }}')"></span>
                                    </div>
                                @endif
                            </button>
                        </div>
                    </div>

                    {{-- Mobile Dropdown Menu --}}
                    <div x-show="mobileMenuOpen"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-2"
                         @click.away="mobileMenuOpen = false"
                         class="absolute top-full left-0 right-0 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-lg"
                         style="display: none;">

                        {{-- User Info --}}
                        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                            <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</p>
                        </div>

                        {{-- Menu Items --}}
                        <div class="py-2">
                            <a href="{{ route('notifications.index') }}"
                               wire:navigate
                               @click="mobileMenuOpen = false"
                               class="flex items-center space-x-3 px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor">
                                    <path d="M192-216v-72h48v-240q0-87 53.5-153T432-763v-53q0-20 14-34t34-14q20 0 34 14t14 34v53q85 16 138.5 82T720-528v240h48v72H192Zm288-276Zm-.21 396Q450-96 429-117.15T408-168h144q0 30-21.21 51t-51 21ZM312-288h336v-240q0-70-49-119t-119-49q-70 0-119 49t-49 119v240Z"/>
                                </svg>
                                <span>Notifications</span>
                            </a>

                            <a href="{{ route('profile') }}"
                               wire:navigate
                               @click="mobileMenuOpen = false"
                               class="flex items-center space-x-3 px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span>Profile</span>
                            </a>

                            {{-- Dark Mode Toggle --}}
                            <div class="px-4 py-3">
                                <livewire:theme-toggle />
                            </div>

                            <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>

                            <button @click="$dispatch('open-modal', 'confirm-logout'); mobileMenuOpen = false"
                                    class="flex items-center space-x-3 w-full px-4 py-3 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 text-left">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span>Log Out</span>
                            </button>
                        </div>
                    </div>
                </header>

                {{-- Desktop Top Header --}}
                <header class="hidden lg:block h-16 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 sticky top-0 z-30">
                    <div class="h-full px-4 flex items-center justify-between">
                        {{-- Left Section: Collapse Button --}}
                        <button @click="toggleSidebar()"
                                class="p-2 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm120-80v-560H200v560h120Zm80 0h360v-560H400v560Zm-80 0H200h120Z"/></svg>
                        </button>

                        {{-- Right Section: Date, Notification Bell, Dark Mode, Profile --}}
                        <div class="flex items-center space-x-4">
                            {{-- Today's Date --}}
                            <div class="hidden md:flex items-center space-x-2 text-gray-600 dark:text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-sm font-medium">{{ now()->format('l, F j, Y') }}</span>
                            </div>

                            {{-- Notification Bell --}}
                            <livewire:notification-bell />

                            {{-- Dark Mode Toggle --}}
                            <livewire:theme-toggle />

                            {{-- User Profile Dropdown --}}
                            <div x-data="{ open: false }" @click.away="open = false" class="relative">
                                <button @click="open = !open"
                                        class="flex items-center space-x-3 p-1 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                    {{-- User Avatar or Initials --}}
                                    @if(auth()->user()->avatar)
                                        <img
                                            src="{{ asset('storage/' . auth()->user()->avatar) }}"
                                            alt="{{ auth()->user()->name }}"
                                            class="w-9 h-9 rounded-full object-cover border-2 border-gray-200 dark:border-gray-600"
                                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="w-9 h-9 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-full flex items-center justify-center" style="display: none;">
                                            <span class="text-white text-sm font-semibold"
                                                  x-text="getInitials('{{ auth()->user()->name }}')"></span>
                                        </div>
                                    @else
                                        <div class="w-9 h-9 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-full flex items-center justify-center">
                                            <span class="text-white text-sm font-semibold"
                                                  x-text="getInitials('{{ auth()->user()->name }}')"></span>
                                        </div>
                                    @endif
                                    <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                {{-- Dropdown Menu --}}
                                <div x-show="open"
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 py-1"
                                     style="display: none;">

                                    {{-- User Info --}}
                                    <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                        <div class="flex items-center space-x-3 mb-2">
                                            @if(auth()->user()->avatar)
                                                <img
                                                    src="{{ asset('storage/' . auth()->user()->avatar) }}"
                                                    alt="{{ auth()->user()->name }}"
                                                    class="w-10 h-10 rounded-full object-cover border-2 border-gray-200 dark:border-gray-600"
                                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                <div class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-full flex items-center justify-center" style="display: none;">
                                                    <span class="text-white text-sm font-semibold"
                                                          x-text="getInitials('{{ auth()->user()->name }}')"></span>
                                                </div>
                                            @else
                                                <div class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-full flex items-center justify-center">
                                                    <span class="text-white text-sm font-semibold"
                                                          x-text="getInitials('{{ auth()->user()->name }}')"></span>
                                                </div>
                                            @endif
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-semibold text-gray-900 dark:text-gray-100 truncate">{{ auth()->user()->name }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ auth()->user()->email }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Menu Items --}}
                                    <a href="{{ route('profile') }}"
                                       wire:navigate
                                       class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <span>Profile</span>
                                    </a>

                                    <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>

                                    <button @click="$dispatch('open-modal', 'confirm-logout')"
                                            class="flex items-center space-x-2 w-full px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 text-left">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        <span>Log Out</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                {{-- Page Heading (Optional) --}}
                @if (isset($header))
                    <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
                        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6">
                            {{ $header }}
                        </div>
                    </div>
                @endif

                {{-- Page Content --}}
                <main class="p-4 sm:p-6">
                    {{ $slot }}
                </main>
            </div>

            {{-- Logout Confirmation Modal --}}
            <x-confirm-modal
                name="confirm-logout"
                title="Log Out?"
                message="Are you sure you want to log out? You will need to sign in again to access your account."
                confirm-text="Yes, Log Out"
                cancel-text="Cancel"
                confirm-color="red"
                @confirmed="$dispatch('logout')"
            />
        </div>
    </body>
</html>
