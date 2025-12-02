<div>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex flex-col gap-2">
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200">
                    Analytics
                </h2>
                <p class="text-sm font-semibold text-gray-400">Visualize and understand your spending patterns</p>
            </div>

            <x-secondary-button wire:click="exportReport">
                <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="currentColor">
                    <path d="M480-336 288-528l51-51 105 105v-342h72v342l105-105 51 51-192 192ZM263.72-192Q234-192 213-213.15T192-264v-72h72v72h432v-72h72v72q0 29.7-21.16 50.85Q725.68-192 695.96-192H263.72Z"/>
                </svg>
                Export Report
            </x-secondary-button>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Period Filter Tabs -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex flex-wrap gap-2">
                        <button
                            wire:click="$set('period', 'this_week')"
                            class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $period === 'this_week' ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                            This Week
                        </button>
                        <button
                            wire:click="$set('period', 'this_month')"
                            class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $period === 'this_month' ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                            This Month
                        </button>
                        <button
                            wire:click="$set('period', '3_months')"
                            class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $period === '3_months' ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                            3 Months
                        </button>
                        <button
                            wire:click="$set('period', 'custom')"
                            class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $period === 'custom' ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                            Custom
                        </button>
                    </div>
                </div>
            </div>

            @if($showDatePicker || $period === 'custom')
            <!-- Custom Date Range Picker -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Select Date Range</h3>
                    <div class="flex flex-wrap gap-4 items-end">
                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <svg class="inline w-5 h-5 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor">
                                    <path d="M216-96q-29.7 0-50.85-21.15Q144-138.3 144-168v-528q0-29.7 21.15-50.85Q186.3-768 216-768h72v-96h72v96h240v-96h72v96h72q29.7 0 50.85 21.15Q816-725.7 816-696v528q0 29.7-21.15 50.85Q773.7-96 744-96H216Zm0-72h528v-360H216v360Z"/>
                                </svg>
                                Start date
                            </label>
                            <input
                                type="date"
                                wire:model="startDate"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                        </div>
                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <svg class="inline w-5 h-5 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor">
                                    <path d="M216-96q-29.7 0-50.85-21.15Q144-138.3 144-168v-528q0-29.7 21.15-50.85Q186.3-768 216-768h72v-96h72v96h240v-96h72v96h72q29.7 0 50.85 21.15Q816-725.7 816-696v528q0 29.7-21.15 50.85Q773.7-96 744-96H216Zm0-72h528v-360H216v360Z"/>
                                </svg>
                                End date
                            </label>
                            <input
                                type="date"
                                wire:model="endDate"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($analytics)
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Spent -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Spent</h3>
                            <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor">
                                <path d="M444-192v-72h72v72h-72Zm0-132v-444h72v444h-72Z"/>
                            </svg>
                        </div>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">₦{{ number_format($analytics['totalSpent'], 0) }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            {{ ucwords(str_replace('_', ' ', $period)) }}
                        </p>
                    </div>
                </div>

                <!-- Daily Average -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Daily Average</h3>
                            <svg class="w-5 h-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor">
                                <path d="m216-160-56-56 464-464H504v-80h280v280h-80v-120L216-160Z"/>
                            </svg>
                        </div>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">₦{{ number_format($analytics['dailyAverage'], 0) }}</p>
                        <p class="text-sm text-green-600 dark:text-green-400 mt-1">Per day average</p>
                    </div>
                </div>

                <!-- Top Category -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Top Category</h3>
                            <svg class="w-5 h-5 text-amber-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor">
                                <path d="m354-287 126-76 126 77-33-144 111-96-146-13-58-136-58 135-146 13 111 97-33 143ZM233-120l65-281L80-590l288-25 112-265 112 265 288 25-218 189 65 281-247-149-247 149Zm247-350Z"/>
                            </svg>
                        </div>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $analytics['topCategory']->name ?? 'N/A' }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            ₦{{ number_format($analytics['topCategory']->total ?? 0, 0) }} spent
                        </p>
                    </div>
                </div>
            </div>

            <!-- Charts Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Spending by Category (Pie Chart) -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-6">Spending by Category</h3>
                        @if($analytics['categoryBreakdown']->count() > 0)
                        <div class="relative h-80">
                            <canvas id="categoryChart"></canvas>
                        </div>
                        @else
                        <div class="flex items-center justify-center h-80 text-gray-400">
                            No expenses in this period
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Daily Spending Trend -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-6">Daily Spending Trend</h3>
                        @if($analytics['dailyTrend']->count() > 0)
                        <div class="relative h-80">
                            <canvas id="trendChart"></canvas>
                        </div>
                        @else
                        <div class="flex items-center justify-center h-80 text-gray-400">
                            No expenses in this period
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Top 10 Expenses -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-6">Top 10 Expenses</h3>
                    @if($analytics['topExpenses']->count() > 0)
                    <div class="space-y-4">
                        @foreach($analytics['topExpenses'] as $expense)
                        <div class="flex items-center">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $expense->description }}</p>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-64 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ ($expense->amount / $analytics['topExpenses']->max('amount')) * 100 }}%"></div>
                                </div>
                                <span class="text-sm font-semibold text-gray-900 dark:text-gray-100 w-24 text-right">
                                    ₦{{ number_format($expense->amount, 0) }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="flex items-center justify-center h-32 text-gray-400">
                        No expenses in this period
                    </div>
                    @endif
                </div>
            </div>

            @else
            <!-- Empty State -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor">
                        <path d="M216-96q-29.7 0-50.85-21.15Q144-138.3 144-168v-528q0-29.7 21.15-50.85Q186.3-768 216-768h72v-96h72v96h240v-96h72v96h72q29.7 0 50.85 21.15Q816-725.7 816-696v528q0 29.7-21.15 50.85Q773.7-96 744-96H216Zm0-72h528v-360H216v360Z"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-semibold text-gray-900 dark:text-gray-100">Select a date range to view analytics</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Choose a preset period or select custom dates above</p>
                </div>
            </div>
            @endif

        </div>
    </div>

    @if($analytics && ($analytics['categoryBreakdown']->count() > 0 || $analytics['dailyTrend']->count() > 0))
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Category Pie Chart
            @if($analytics['categoryBreakdown']->count() > 0)
            const categoryCtx = document.getElementById('categoryChart');
            if (categoryCtx) {
                new Chart(categoryCtx, {
                    type: 'pie',
                    data: {
                        labels: {!! json_encode($analytics['categoryBreakdown']->pluck('name')) !!},
                        datasets: [{
                            data: {!! json_encode($analytics['categoryBreakdown']->pluck('total')) !!},
                            backgroundColor: {!! json_encode($analytics['categoryBreakdown']->pluck('color')) !!},
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    generateLabels: function(chart) {
                                        const data = chart.data;
                                        return data.labels.map((label, i) => {
                                            const percentage = {{ json_encode($analytics['categoryBreakdown']->pluck('percentage')) }}[i];
                                            return {
                                                text: `${label}: ${percentage}%`,
                                                fillStyle: data.datasets[0].backgroundColor[i],
                                            };
                                        });
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
            }
            @endif

            // Daily Trend Line Chart
            @if($analytics['dailyTrend']->count() > 0)
            const trendCtx = document.getElementById('trendChart');
            if (trendCtx) {
                new Chart(trendCtx, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($analytics['dailyTrend']->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('M j'))) !!},
                        datasets: [{
                            label: 'Amount (₦)',
                            data: {!! json_encode($analytics['dailyTrend']->pluck('total')) !!},
                            borderColor: '#6366f1',
                            backgroundColor: 'rgba(99, 102, 241, 0.1)',
                            tension: 0.4,
                            fill: true,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
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
                                    callback: function(value) {
                                        return '₦' + value.toLocaleString();
                                    }
                                }
                            }
                        }
                    }
                });
            }
            @endif
        });

        // Re-render charts on Livewire updates
        Livewire.hook('morph.updated', () => {
            location.reload();
        });
    </script>
    @endpush
    @endif
</div>
