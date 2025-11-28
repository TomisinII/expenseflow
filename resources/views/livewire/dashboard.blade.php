<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-6">Dashboard</h2>

                    {{-- Summary Cards --}}
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600">Today</p>
                            <p class="text-2xl font-bold text-blue-600">${{ number_format($today, 2) }}</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600">This Week</p>
                            <p class="text-2xl font-bold text-green-600">${{ number_format($thisWeek, 2) }}</p>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600">This Month</p>
                            <p class="text-2xl font-bold text-purple-600">${{ number_format($thisMonth, 2) }}</p>
                        </div>
                        <div class="bg-indigo-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600">This Year</p>
                            <p class="text-2xl font-bold text-indigo-600">${{ number_format($thisYear, 2) }}</p>
                        </div>
                    </div>

                    {{-- Recent Expenses --}}
                    <h3 class="text-xl font-semibold mb-4">Recent Expenses</h3>
                    @if($recentExpenses->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($recentExpenses as $expense)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $expense->expense_date->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $expense->description }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full"
                                                      style="background-color: {{ $expense->category->color }}20; color: {{ $expense->category->color }}">
                                                    {{ $expense->category->name }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                                ${{ number_format($expense->amount, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12 bg-gray-50 rounded-lg">9
                            <p class="text-gray-500">No expenses yet. Start tracking your spending!</p>
                            <a href="{{ route('expenses.index') }}" class="mt-4 inline-block text-indigo-600 hover:text-indigo-700">
                                Add your first expense →
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
