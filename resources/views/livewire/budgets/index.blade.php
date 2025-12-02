<div>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex flex-col gap-2">
                <h2 class="font-bold text-2xl text-gray-800">
                    Budgets
                </h2>
                <p class="text-sm font-semibold text-gray-400">Track your spending against monthly budgets</p>
            </div>

            <x-primary-button x-on:click="$dispatch('open-modal', 'add-budget')">
                <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="currentColor"><path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"/></svg>
                Add Budget
            </x-primary-button>

        </div>
    </x-slot>

    {{-- Success Message --}}
    <x-action-message on="message" class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center justify-between min-w-80">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <span x-text="message"></span>
        </div>
    </x-action-message>

    <div class="space-y-6">
        {{-- Month/Year Selector and Total --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="text-gray-700 font-medium">Viewing:</span>
                    <select wire:model.live="selectedMonth"
                        class="w-full pr-16 mt-1 border-gray-300 focus:border-purple-600 focus:ring-purple-600 rounded-md shadow-sm"
                    >
                        @foreach($months as $num => $name)
                            <option value="{{ $num }}">{{ $name }}</option>
                        @endforeach
                    </select>
                    <select wire:model.live="selectedYear"
                        class="w-full mt-1 border-gray-300 focus:border-purple-600 focus:ring-purple-600 rounded-md shadow-sm"
                    >
                        @for($y = date('Y'); $y >= 2020; $y--)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endfor
                    </select>
                </div>

                <div class="text-right">
                    <p class="text-sm text-gray-500 mb-1">Total Budget</p>
                    <p class="text-2xl font-bold text-gray-900">
                        ₦{{ number_format($totalSpent, 0) }} <span class="text-gray-400">/</span>₦{{ number_format($totalAllocated, 0) }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Budget Cards Grid --}}
        @if($budgets->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($budgets as $budget)
                    <div class="bg-white rounded-xl border
                        @if($budget->status === 'near-limit') border-yellow-300
                        @elseif($budget->status === 'over-budget') border-red-300
                        @else border-gray-200
                        @endif p-6 relative"
                    >

                        {{-- Status Badge --}}
                        <div class="absolute top-4 right-4">
                            @if($budget->status === 'on-track')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    On Track
                                </span>
                            @elseif($budget->status === 'near-limit')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    Near Limit
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                    Over Budget
                                </span>
                            @endif
                        </div>

                        {{-- Category Name --}}
                        <h3 class="text-xl font-bold text-gray-900 mb-4">{{ $budget->category->name }}</h3>

                        {{-- Amounts --}}
                        <div class="mb-4">
                            <div class="flex justify-between items-baseline gap-2">
                                <span class="text-3xl font-bold text-gray-900">₦{{ number_format($budget->spent, 0) }}</span>
                                <span class="text-gray-500">of ₦{{ number_format($budget->amount, 0) }}</span>
                            </div>
                        </div>

                        {{-- Progress Bar --}}
                        <div class="mb-3">
                            <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-300
                                    @if($budget->status === 'over-budget') bg-red-500
                                    @elseif($budget->status === 'near-limit') bg-yellow-500
                                    @else bg-gradient-to-r from-indigo-500 to-purple-500
                                    @endif"
                                    style="width: {{ min($budget->percentage, 100) }}%">
                                </div>
                            </div>
                        </div>

                        {{-- Stats --}}
                        <div class="flex items-center justify-between text-sm">
                            <span class="font-semibold
                                @if($budget->status === 'over-budget') text-red-600
                                @elseif($budget->status === 'near-limit') text-yellow-600
                                @else text-green-600
                                @endif">
                                {{ number_format($budget->percentage, 1) }}% used
                            </span>
                            <span class="text-gray-500">₦{{ number_format($budget->remaining, 0) }} left</span>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Budget Summary --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Budget Summary</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <p class="text-sm text-gray-500 mb-2">Total Allocated</p>
                        <p class="text-3xl font-bold text-gray-900">₦{{ number_format($totalAllocated, 0) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-2">Total Spent</p>
                        <p class="text-3xl font-bold text-indigo-600">₦{{ number_format($totalSpent, 0) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-2">Remaining</p>
                        <p class="text-3xl font-bold text-green-600">₦{{ number_format($totalRemaining, 0) }}</p>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-xl border border-gray-200 p-12">
                <div class="text-center text-gray-400">
                    <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-lg font-medium mb-2">No budgets set for {{ $months[$selectedMonth] }} {{ $selectedYear }}</p>
                    <p class="text-sm mb-4">Create your first budget to start tracking your spending</p>
                    <x-primary-button x-on:click="$dispatch('open-modal', 'add-budget')"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Add Your First Budget
                    </x-primary-button>
                </div>
            </div>
        @endif
    </div>

    {{-- Add Budget Modal --}}
    @livewire('budgets.create')
</div>
