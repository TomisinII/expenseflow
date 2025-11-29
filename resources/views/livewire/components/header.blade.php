<header class="bg-white shadow-sm sticky top-0 z-50" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-16">
        <div class="flex justify-between items-center h-16">
            {{-- Logo --}}
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <div class="text-2xl font-bold">
                        <span class="text-indigo-600">Expense</span><span class="text-purple-600">Flow</span>
                    </div>
                </a>
            </div>

            {{-- Desktop Navigation --}}
            <div class="hidden md:flex items-center space-x-4">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="border-2 border-gray-600 hover:border-gray-900 text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium transition duration-150">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        Log in
                    </a>
                    <a href="{{ route('register') }}">
                        <x-primary-button>
                            Get Started
                        </x-primary-button>
                    </a>
                @endauth
            </div>

            {{-- Mobile Menu Button --}}
            <div class="md:hidden">
                <button @click="open = !open"
                        type="button"
                        class="text-gray-600 hover:text-gray-900 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Backdrop --}}
    <div x-show="open"
         x-transition:enter="transition-opacity ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="open = false"
         class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden"
         x-cloak>
    </div>

    {{-- Mobile Menu Slide-out --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="fixed top-0 right-0 h-full w-64 bg-white shadow-xl z-50 md:hidden"
         x-cloak>
        <div class="flex flex-col h-full">
            {{-- Close Button --}}
            <div class="flex justify-end p-4">
                <button @click="open = false"
                        type="button"
                        class="text-gray-600 hover:text-gray-900 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Menu Items --}}
            <div class="flex flex-col space-y-4 px-6 py-4">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="border-2 border-gray-600 hover:border-gray-900 text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-base font-medium text-center">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="border-2 border-gray-600 hover:border-gray-900 text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-base font-medium text-center">
                        Log in
                    </a>
                    <a href="{{ route('register') }}"
                       class="border-2 border-indigo-600 hover:border-indigo-700 bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded-md text-base font-medium text-center">
                        Get Started
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>
