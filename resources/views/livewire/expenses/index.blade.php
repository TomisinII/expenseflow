<div>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex flex-col gap-2">
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100">
                    Expenses
                </h2>
                <p class="text-sm font-semibold text-gray-400 dark:text-gray-500">Manage and track all your expenses</p>
            </div>

            <x-primary-button x-on:click="$dispatch('open-modal', 'add-expense')" class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="currentColor"><path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"/></svg>
                Add Expense
            </x-primary-button>
        </div>
    </x-slot>

    {{-- Success Message --}}
    <x-action-message on="message" class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-300 px-4 py-3 rounded-lg flex items-center justify-between min-w-80">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <span x-text="message"></span>
        </div>
    </x-action-message>

    <div
        class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6"
        x-data="{ showFilters: false }"
        @close-filters.window="showFilters = false"
    >
        {{-- Search and Action Buttons --}}
        <div class="flex items-center gap-4 mb-6">
            {{-- Search Input --}}
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <x-text-input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search expenses..."
                    class="w-full pl-10"
                />
            </div>

            {{-- Filters Button --}}
            <button
                @click="showFilters = !showFilters"
                class="flex items-center gap-2 px-4 py-2 text-sm border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition"
                :class="{ 'bg-gray-50 dark:bg-gray-700': showFilters }">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                Filters
            </button>

            {{-- Export CSV Button --}}
            <button
                wire:click="exportCsv"
                wire:loading.attr="disabled"
                wire:loading.class="opacity-50 cursor-not-allowed"
                class="flex items-center gap-2 px-4 py-2 text-sm border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                <span wire:loading.remove>Export CSV</span>
                <span wire:loading>Exporting...</span>
            </button>
        </div>

        {{-- Filter Panel --}}
        <div x-show="showFilters"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                {{-- Category Filter --}}
                <div>
                    <x-input-label for="filterCategory" :value="('Category')" />
                    <select
                        wire:model="filterCategory"
                        class="w-full mt-1 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:border-purple-600 dark:focus:border-purple-500 focus:ring-purple-600 dark:focus:ring-purple-500 rounded-md shadow-sm">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- From Date --}}
                <div>
                    <x-input-label for="filterFromDate" :value="('From Date')" />

                    <x-text-input
                        type="date"
                        wire:model="filterFromDate"
                        id="filterFromDate"
                        class="block mt-1 w-full"
                        required
                    />
                </div>

                {{-- To Date --}}
                <div>
                   <x-input-label for="filterToDate" :value="('To Date')" />

                    <x-text-input
                        type="date"
                        wire:model="filterToDate"
                        id="filterToDate"
                        class="block mt-1 w-full"
                        required
                    />
                </div>

                {{-- Payment Method --}}
                <div>
                   <x-input-label for="filterPaymentMethod" :value="('Payment Method')" />

                    <select
                        wire:model="filterPaymentMethod"
                        class="w-full mt-1 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:border-purple-600 dark:focus:border-purple-500 focus:ring-purple-600 dark:focus:ring-purple-500 rounded-md shadow-sm">
                        <option value="">All Methods</option>
                        <option value="cash">Cash</option>
                        <option value="card">Card</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                {{-- Min Amount --}}
                <div>
                   <x-input-label for="filterMinAmount" :value="('Min Amount')" />

                    <x-text-input
                        type="number"
                        wire:model="filterMinAmount"
                        id="filterMinAmount"
                        placeholder="$0"
                        class="block mt-1 w-full"
                        required
                    />
                </div>

                {{-- Max Amount --}}
                <div>
                    <x-input-label for="filterMaxAmount" :value="('Max Amount')" />

                    <x-text-input
                        type="number"
                        wire:model="filterMaxAmount"
                        id="filterMaxAmount"
                        placeholder="$0"
                        class="block mt-1 w-full"
                        required
                    />

                </div>

                {{-- Apply Filters Button --}}
                <div class="flex items-end">
                    <x-primary-button
                        wire:click="applyFilters"
                        class="justify-center w-full">
                        Apply Filters
                    </x-primary-button>
                </div>

                {{-- Reset Button --}}
                <div class="flex items-end">
                    <x-secondary-button
                        wire:click="resetFilters"
                        class="justify-center w-full">
                        Reset
                    </x-secondary-button>
                </div>
            </div>
        </div>

        {{-- Expenses Table --}}
        <div class="overflow-x-auto"
             x-data="{ expenseToDelete: null }"
             @confirmed.window="
                if ($event.detail === 'delete-expense' && expenseToDelete) {
                    $wire.delete(expenseToDelete);
                    expenseToDelete = null;
                }
             ">
            @if($expenses->count() > 0)
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="text-left py-4 px-4 w-12">
                                <input type="checkbox" class="w-4 h-4 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-indigo-600 dark:text-indigo-500 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                            </th>
                            <th class="text-left py-4 px-4 text-sm font-semibold text-gray-500 dark:text-gray-400">Date</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold text-gray-500 dark:text-gray-400">Description</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold text-gray-500 dark:text-gray-400">Category</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold text-gray-500 dark:text-gray-400">Payment</th>
                            <th class="text-right py-4 px-4 text-sm font-semibold text-gray-500 dark:text-gray-400">Amount</th>
                            <th class="text-right py-4 px-4 text-sm font-semibold text-gray-500 dark:text-gray-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($expenses as $expense)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                {{-- Checkbox --}}
                                <td class="py-4 px-4">
                                    <input type="checkbox" class="w-4 h-4 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-indigo-600 dark:text-indigo-500 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                </td>

                                {{-- Date --}}
                                <td class="py-4 px-4 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $expense->expense_date->format('M d, Y') }}
                                </td>

                                {{-- Description --}}
                                <td class="py-4 px-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $expense->description }}
                                </td>

                                {{-- Category --}}
                                <td class="py-4 px-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                        {{ $expense->category->name }}
                                    </span>
                                </td>

                                {{-- Payment Method --}}
                                <td class="py-4 px-4 text-sm text-gray-600 dark:text-gray-400 capitalize">
                                    {{ str_replace('_', ' ', $expense->payment_method) }}
                                </td>

                                {{-- Amount --}}
                                <td class="py-4 px-4 text-right text-sm font-bold text-gray-900 dark:text-gray-100">
                                    ₦{{ number_format($expense->amount, 0) }}
                                </td>

                                {{-- Actions --}}
                                <td class="py-4 px-4 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        {{-- Edit Button --}}
                                        <button
                                            wire:click="edit({{ $expense->id }})"
                                            class="p-2 text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="currentColor">
                                                <path d="M216-144q-29.7 0-50.85-21.15Q144-186.3 144-216v-528q0-30.11 21-51.56Q186-817 216-816h346l-72 72H216v528h528v-274l72-72v346q0 29.7-21.15 50.85Q773.7-144 744-144H216Zm264-336Zm-96 96v-153l354-354q11-11 24-16t26.5-5q14.4 0 27.45 5 13.05 5 23.99 15.78L891-840q11 11 16 24.18t5 26.82q0 13.66-5.02 26.87-5.02 13.2-15.98 24.13L537-384H384Zm456-405-51-51 51 51ZM456-456h51l231-231-25-26-26-25-231 231v51Zm257-257-26-25 26 25 25 26-25-26Z"/>
                                            </svg>
                                        </button>

                                        {{-- Delete Button --}}
                                        <button
                                            @click="expenseToDelete = {{ $expense->id }}; $dispatch('open-modal', 'delete-expense')"
                                            class="p-2 text-red-400 hover:text-red-600 dark:text-red-500 dark:hover:text-red-400 transition"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="currentColor">
                                                <path d="M312-144q-29.7 0-50.85-21.15Q240-186.3 240-216v-480h-48v-72h192v-48h192v48h192v72h-48v479.57Q720-186 698.85-165T648-144H312Zm336-552H312v480h336v-480ZM384-288h72v-336h-72v336Zm120 0h72v-336h-72v336ZM312-696v480-480Z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="mt-6">
                    {{ $expenses->links() }}
                </div>
            @else
                {{-- Empty State --}}
                <div class="text-center py-12 text-gray-400 dark:text-gray-500">
                    <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-lg font-medium text-gray-600 dark:text-gray-300">No expenses found</p>
                    <p class="text-sm mt-1">
                        {{ $search ? 'Try adjusting your search' : 'Start tracking your spending by adding your first expense!' }}
                    </p>
                </div>
            @endif

            {{-- Confirmation Modal for Delete --}}
            <x-confirm-modal
                name="delete-expense"
                title="Delete Expense"
                message="Are you sure you want to delete this expense? This action cannot be undone."
                confirmText="Delete"
                cancelText="Cancel"
                confirmColor="red"
            />
        </div>
    </div>

    {{-- Scroll to Top Handler --}}
    <div x-data="{}"
         @scroll-to-top.window="window.scrollTo({ top: 0, behavior: 'smooth' })"
         style="display: none;">
    </div>

    {{-- Livewire Components --}}
    @livewire('expenses.create')
    @livewire('expenses.edit')
</div>
