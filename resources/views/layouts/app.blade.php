{{-- layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
            sidebarOpen: true,
            darkMode: false,
            toggleSidebar() {
                this.sidebarOpen = !this.sidebarOpen;
            },
            toggleDarkMode() {
                this.darkMode = !this.darkMode;
                // You can add logic to save preference to database here
            },
            getInitials(name) {
                return name.split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2);
            }
        }" class="min-h-screen bg-gray-50">

            {{-- Include Sidebar Navigation --}}
            <livewire:layout.navigation />

            {{-- Main Content Area --}}
            <div :class="sidebarOpen ? 'ml-64' : 'ml-20'" class="transition-all duration-300 ease-in-out">
                {{-- Top Header --}}
                <header class="h-16 bg-white border-b border-gray-200 sticky top-0 z-30">
                    <div class="h-full px-4 flex items-center justify-between">
                        {{-- Left Section: Collapse Button --}}
                        <button @click="toggleSidebar()"
                                class="p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm120-80v-560H200v560h120Zm80 0h360v-560H400v560Zm-80 0H200h120Z"/></svg>
                        </button>

                        {{-- Right Section: Date, Dark Mode, Profile --}}
                        <div class="flex items-center space-x-4">
                            {{-- Today's Date --}}
                            <div class="hidden md:flex items-center space-x-2 text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-sm font-medium">{{ now()->format('l, F j, Y') }}</span>
                            </div>

                            {{-- Dark Mode Toggle --}}
                            <button @click="toggleDarkMode()"
                                    class="p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition">
                                <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                                <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </button>

                            {{-- User Profile Dropdown --}}
                            <div x-data="{ open: false }" @click.away="open = false" class="relative">
                                <button @click="open = !open"
                                        class="flex items-center space-x-3 p-1 rounded-lg hover:bg-gray-100 transition">
                                    {{-- User Initials Avatar --}}
                                    <div class="w-9 h-9 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-full flex items-center justify-center">
                                        <span class="text-white text-sm font-semibold"
                                              x-text="getInitials('{{ auth()->user()->name }}')"></span>
                                    </div>
                                    <svg class="w-4 h-4 text-gray-600" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                     class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 py-1"
                                     style="display: none;">

                                    {{-- User Info --}}
                                    <div class="px-4 py-3 border-b border-gray-200">
                                        <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                    </div>

                                    {{-- Menu Items --}}
                                    <a href="{{ route('profile') }}"
                                       wire:navigate
                                       class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <span>Profile</span>
                                    </a>

                                    <div class="border-t border-gray-200 my-1"></div>

                                    <button wire:click="$dispatch('logout')"
                                            class="flex items-center space-x-2 w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 text-left">
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
                    <div class="bg-white shadow-sm border-b border-gray-200">
                        <div class="max-w-7xl mx-auto py-4 px-6">
                            {{ $header }}
                        </div>
                    </div>
                @endif

                {{-- Page Content --}}
                <main class="p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
