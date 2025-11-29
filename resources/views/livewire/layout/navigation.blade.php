<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div @logout.window="$wire.logout()">
{{-- Sidebar Navigation --}}
<aside x-data="{ sidebarOpen: $parent.sidebarOpen }"
       :class="sidebarOpen ? 'w-64' : 'w-20'"
       class="fixed left-0 top-0 h-full bg-white border-r border-gray-200 transition-all duration-300 ease-in-out z-40">

    {{-- Logo Section --}}
    <div class="h-16 flex items-center border-b border-gray-200 px-4">
        <div x-show="sidebarOpen" class="flex items-center space-x-2">
            <div class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center">
                <span class="text-white font-bold text-lg">E</span>
            </div>
            <div class="font-bold">
                <span class="text-indigo-600">Expense</span><span class="text-purple-600">Flow</span>
            </div>
        </div>
        <div x-show="!sidebarOpen" class="w-10 h-10 mx-auto bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center">
            <span class="text-white font-bold text-lg">E</span>
        </div>
    </div>

    {{-- Navigation Links --}}
    <nav class="p-4 space-y-2">
        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}"
           wire:navigate
           class="flex items-center space-x-2 px-4 py-3 rounded-lg text-sm transition {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-100' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span x-show="sidebarOpen" class="font-medium">Dashboard</span>
        </a>

        {{-- Expenses --}}
        <a href="{{ route('expenses.index') }}"
           wire:navigate
           class="flex items-center space-x-2 text-sm px-4 py-3 rounded-lg transition {{ request()->routeIs('expenses.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-100' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
            </svg>
            <span x-show="sidebarOpen" class="font-medium">Expenses</span>
        </a>

        {{-- Categories --}}
        <a href="{{ route('categories.index') }}"
           wire:navigate
           class="flex items-center space-x-2 text-sm px-4 py-3 rounded-lg transition {{ request()->routeIs('categories.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-100' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
            </svg>
            <span x-show="sidebarOpen" class="font-medium">Categories</span>
        </a>

        {{-- Budgets --}}
        <a href="{{ route('budgets.index') }}"
           wire:navigate
           class="flex items-center space-x-2 text-sm px-4 py-3 rounded-lg transition {{ request()->routeIs('budgets.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-100' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span x-show="sidebarOpen" class="font-medium">Budgets</span>
        </a>

        {{-- Analytics --}}
        <a href="{{ route('analytics') }}"
           wire:navigate
           class="flex items-center space-x-2 text-sm px-4 py-3 rounded-lg transition {{ request()->routeIs('analytics') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-100' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            <span x-show="sidebarOpen" class="font-medium">Analytics</span>
        </a>

        {{-- Profile --}}
        <a href="{{ route('profile') }}"
           wire:navigate
           class="flex items-center space-x-2 text-sm px-4 py-3 rounded-lg transition {{ request()->routeIs('profile') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-100' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span x-show="sidebarOpen" class="font-medium">Profile</span>
        </a>
    </nav>
</aside>
</div>
