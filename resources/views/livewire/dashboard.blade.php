<div>
    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between lg:relative">
            {{-- Title and Description --}}
            <div class="flex flex-col gap-2">
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200">
                    Dashboard
                </h2>
                <p class="text-sm font-semibold text-gray-400 dark:text-gray-500">Welcome back! Here's your financial overview</p>
            </div>

            {{-- Add Expense Button (Full Width on Mobile) --}}
            <x-primary-button x-on:click="$dispatch('open-modal', 'add-expense')" class="w-full justify-center lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="currentColor"><path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"/></svg>
                Add Expense
            </x-primary-button>

            {{-- Desktop Button (Hidden on Mobile) --}}
            <div class="hidden lg:block">
                <x-primary-button x-on:click="$dispatch('open-modal', 'add-expense')" class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="currentColor"><path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"/></svg>
                    Add Expense
                </x-primary-button>
            </div>
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

    <div class="space-y-6">
        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Today Card --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Today</span>
                    <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                    ₦{{ number_format($today, 0) }}
                </div>
                <div class="flex items-center text-sm">
                    @if($todayChange === 'increase')
                        <svg class="w-4 h-4 text-green-500 dark:text-green-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <span class="text-green-600 dark:text-green-400 font-medium">{{ $todayTransactions }} transactions</span>
                    @elseif($todayChange === 'decrease')
                        <svg class="w-4 h-4 text-red-500 dark:text-red-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                        </svg>
                        <span class="text-red-600 dark:text-red-400 font-medium">{{ $todayTransactions }} transactions</span>
                    @else
                        <span class="text-gray-600 dark:text-gray-400 font-medium">— {{ $todayTransactions }} transactions</span>
                    @endif
                </div>
            </div>

            {{-- This Week Card --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">This Week</span>
                    <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                    ₦{{ number_format($thisWeek, 0) }}
                </div>
                <div class="flex items-center text-sm">
                    @if($thisWeekChange === 'increase')
                        <svg class="w-4 h-4 text-green-500 dark:text-green-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <span class="text-green-600 dark:text-green-400 font-medium">{{ $thisWeekTransactions }} transactions</span>
                    @elseif($thisWeekChange === 'decrease')
                        <svg class="w-4 h-4 text-red-500 dark:text-red-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                        </svg>
                        <span class="text-red-600 dark:text-red-400 font-medium">{{ $thisWeekTransactions }} transactions</span>
                    @else
                        <span class="text-gray-600 dark:text-gray-400 font-medium">— {{ $thisWeekTransactions }} transactions</span>
                    @endif
                </div>
            </div>

            {{-- This Month Card --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">This Month</span>
                    <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                    ₦{{ number_format($thisMonth, 0) }}
                </div>
                <div class="flex items-center text-sm">
                    @if($thisMonthChange === 'increase')
                        <svg class="w-4 h-4 text-green-500 dark:text-green-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <span class="text-green-600 dark:text-green-400 font-medium">{{ $thisMonthTransactions }} transactions</span>
                    @elseif($thisMonthChange === 'decrease')
                        <svg class="w-4 h-4 text-red-500 dark:text-red-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                        </svg>
                        <span class="text-red-600 dark:text-red-400 font-medium">{{ $thisMonthTransactions }} transactions</span>
                    @else
                        <span class="text-gray-600 dark:text-gray-400 font-medium">— {{ $thisMonthTransactions }} transactions</span>
                    @endif
                </div>
            </div>

            {{-- This Year Card --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">This Year</span>
                    <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                    ₦{{ number_format($thisYear, 0) }}
                </div>
                <div class="flex items-center text-sm">
                    @if($thisYearChange === 'increase')
                        <svg class="w-4 h-4 text-green-500 dark:text-green-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <span class="text-green-600 dark:text-green-400 font-medium">{{ $thisYearTransactions }} transactions</span>
                    @elseif($thisYearChange === 'decrease')
                        <svg class="w-4 h-4 text-red-500 dark:text-red-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                        </svg>
                        <span class="text-red-600 dark:text-red-400 font-medium">{{ $thisYearTransactions }} transactions</span>
                    @else
                        <span class="text-gray-600 dark:text-gray-400 font-medium">— {{ $thisYearTransactions }} transactions</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Charts Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Spending by Category (Pie Chart) --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-6">Spending by Category</h3>
                <div class="h-64">
                    @if(count($categoryLabels) > 0)
                        <canvas
                            wire:key="category-chart-{{ now()->timestamp }}"
                            x-data="{
                                chart: null,
                                init() {
                                    const isDark = document.documentElement.classList.contains('dark');
                                    this.chart = new Chart(this.$el, {
                                        type: 'doughnut',
                                        data: {
                                            labels: @js($categoryLabels),
                                            datasets: [{
                                                data: @js($categoryAmounts),
                                                backgroundColor: @js($categoryColors),
                                                borderWidth: 2,
                                                borderColor: isDark ? '#1f2937' : '#fff'
                                            }]
                                        },
                                        options: {
                                            responsive: true,
                                            maintainAspectRatio: false,
                                            plugins: {
                                                legend: {
                                                    position: 'right',
                                                    labels: {
                                                        padding: 15,
                                                        font: {
                                                            size: 12
                                                        },
                                                        color: isDark ? '#d1d5db' : '#374151',
                                                        generateLabels: function(chart) {
                                                            const data = chart.data;
                                                            return data.labels.map((label, i) => ({
                                                                text: label + ': ₦' + data.datasets[0].data[i].toLocaleString(),
                                                                fillStyle: data.datasets[0].backgroundColor[i],
                                                                hidden: false,
                                                                index: i
                                                            }));
                                                        }
                                                    }
                                                },
                                                tooltip: {
                                                    callbacks: {
                                                        label: function(context) {
                                                            return context.label + ': ₦' + context.parsed.toLocaleString();
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    });
                                },
                                destroy() {
                                    if (this.chart) {
                                        this.chart.destroy();
                                    }
                                }
                            }"
                            x-init="init()"
                            @destroy.window="destroy()">
                        </canvas>
                    @else
                        <div class="h-full flex items-center justify-center text-gray-400 dark:text-gray-500">
                            <div class="text-center">
                                <svg class="w-16 h-16 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                </svg>
                                <p class="text-sm">No spending data this month</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- 7-Day Spending Trend (Line Chart) --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-6">7-Day Spending Trend</h3>
                <div class="h-64">
                    @if(array_sum($trendData) > 0)
                        <canvas
                            wire:key="trend-chart-{{ now()->timestamp }}"
                            x-data="{
                                chart: null,
                                init() {
                                    const isDark = document.documentElement.classList.contains('dark');
                                    this.chart = new Chart(this.$el, {
                                        type: 'line',
                                        data: {
                                            labels: @js($trendLabels),
                                            datasets: [{
                                                label: 'Amount (₦)',
                                                data: @js($trendData),
                                                borderColor: '#6366f1',
                                                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                                                borderWidth: 3,
                                                tension: 0.4,
                                                fill: true,
                                                pointRadius: 4,
                                                pointBackgroundColor: '#6366f1',
                                                pointBorderColor: isDark ? '#1f2937' : '#fff',
                                                pointBorderWidth: 2,
                                                pointHoverRadius: 6
                                            }]
                                        },
                                        options: {
                                            responsive: true,
                                            maintainAspectRatio: false,
                                            plugins: {
                                                legend: {
                                                    display: true,
                                                    position: 'bottom',
                                                    labels: {
                                                        font: {
                                                            size: 12
                                                        },
                                                        color: isDark ? '#d1d5db' : '#374151',
                                                        usePointStyle: true
                                                    }
                                                },
                                                tooltip: {
                                                    callbacks: {
                                                        label: function(context) {
                                                            return 'Amount: ₦' + context.parsed.y.toLocaleString();
                                                        }
                                                    }
                                                }
                                            },
                                            scales: {
                                                y: {
                                                    beginAtZero: true,
                                                    ticks: {
                                                        color: isDark ? '#d1d5db' : '#6b7280',
                                                        callback: function(value) {
                                                            return '₦' + value.toLocaleString();
                                                        }
                                                    },
                                                    grid: {
                                                        color: isDark ? '#374151' : '#e5e7eb'
                                                    }
                                                },
                                                x: {
                                                    ticks: {
                                                        color: isDark ? '#d1d5db' : '#6b7280'
                                                    },
                                                    grid: {
                                                        color: isDark ? '#374151' : '#e5e7eb'
                                                    }
                                                }
                                            }
                                        }
                                    });
                                },
                                destroy() {
                                    if (this.chart) {
                                        this.chart.destroy();
                                    }
                                }
                            }"
                            x-init="init()"
                            @destroy.window="destroy()">
                        </canvas>
                    @else
                        <div class="h-full flex items-center justify-center text-gray-400 dark:text-gray-500">
                            <div class="text-center">
                                <svg class="w-16 h-16 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                                </svg>
                                <p class="text-sm">No spending data for the last 7 days</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Recent Expenses --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6"
            x-data="{ expenseToDelete: null }"
            @confirmed.window="
                if ($event.detail === 'delete-expense' && expenseToDelete) {
                    $wire.deleteExpense(expenseToDelete);
                    expenseToDelete = null;
                }
            ">
            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-6">Recent Expenses</h3>

            @if($recentExpenses->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-500 dark:text-gray-400">Date</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-500 dark:text-gray-400">Description</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-500 dark:text-gray-400">Category</th>
                                <th class="text-right py-3 px-4 text-sm font-semibold text-gray-500 dark:text-gray-400">Amount</th>
                                <th class="text-right py-3 px-4 text-sm font-semibold text-gray-500 dark:text-gray-400">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($recentExpenses as $expense)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <td class="py-4 px-4 text-sm text-gray-600 dark:text-gray-400">
                                        {{ $expense->expense_date->format('M d') }}
                                    </td>
                                    <td class="py-4 px-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $expense->description }}
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                            {{ $expense->category->name }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4 text-right text-sm font-bold text-gray-900 dark:text-gray-100">
                                        ₦{{ number_format($expense->amount, 0) }}
                                    </td>
                                    <td class="py-4 px-4 text-right">
                                        <div class="flex items-center justify-end space-x-1">
                                            {{-- Edit Button --}}
                                            <button
                                                wire:click="editExpense({{ $expense->id }})"
                                                class="p-2 text-gray-400 dark:text-gray-500 hover:text-indigo-600 dark:hover:text-indigo-400 transition"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="currentColor">
                                                    <path d="M216-144q-29.7 0-50.85-21.15Q144-186.3 144-216v-528q0-30.11 21-51.56Q186-817 216-816h346l-72 72H216v528h528v-274l72-72v346q0 29.7-21.15 50.85Q773.7-144 744-144H216Zm264-336Zm-96 96v-153l354-354q11-11 24-16t26.5-5q14.4 0 27.45 5 13.05 5 23.99 15.78L891-840q11 11 16 24.18t5 26.82q0 13.66-5.02 26.87-5.02 13.2-15.98 24.13L537-384H384Zm456-405-51-51 51 51ZM456-456h51l231-231-25-26-26-25-231 231v51Zm257-257-26-25 26 25 25 26-25-26Z"/>
                                                </svg>
                                            </button>

                                            {{-- Delete Button --}}
                                            <button @click="expenseToDelete = {{ $expense->id }}; $dispatch('open-modal', 'delete-expense')"
                                                    class="p-2 text-red-400 dark:text-red-500 hover:text-red-600 dark:hover:text-red-400 transition"
                                                    title="Delete expense">
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
                </div>
            @else
                <div class="text-center py-12 text-gray-400 dark:text-gray-500">
                    <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-lg font-medium">No expenses yet</p>
                    <p class="text-sm mt-1">Start tracking your spending by adding your first expense!</p>
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

        @livewire('expenses.create')
        @livewire('expenses.edit')
    </div>

    <div x-data="{}"
        @scroll-to-top.window="window.scrollTo({ top: 0, behavior: 'smooth' })"
        style="display: none;">
    </div>
</div>
