<?php

namespace App\Livewire;

use App\Models\Expense;
use Carbon\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $user = auth()->user();

        // Calculate totals
        $today = Expense::where('user_id', $user->id)
            ->whereDate('expense_date', Carbon::today())
            ->sum('amount');

        $thisWeek = Expense::where('user_id', $user->id)
            ->whereBetween('expense_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->sum('amount');

        $thisMonth = Expense::where('user_id', $user->id)
            ->whereMonth('expense_date', Carbon::now()->month)
            ->whereYear('expense_date', Carbon::now()->year)
            ->sum('amount');

        $thisYear = Expense::where('user_id', $user->id)
            ->whereYear('expense_date', Carbon::now()->year)
            ->sum('amount');

        // Calculate transaction counts
        $todayTransactions = Expense::where('user_id', $user->id)
            ->whereDate('expense_date', Carbon::today())
            ->count();

        $thisWeekTransactions = Expense::where('user_id', $user->id)
            ->whereBetween('expense_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();

        $thisMonthTransactions = Expense::where('user_id', $user->id)
            ->whereMonth('expense_date', Carbon::now()->month)
            ->whereYear('expense_date', Carbon::now()->year)
            ->count();

        $thisYearTransactions = Expense::where('user_id', $user->id)
            ->whereYear('expense_date', Carbon::now()->year)
            ->count();

        // Get recent expenses
        $recentExpenses = Expense::with('category')
            ->where('user_id', $user->id)
            ->orderBy('expense_date', 'desc')
            ->take(10)
            ->get();

        // ====== CHART DATA ======

        // Spending by Category (Pie Chart)
        $categoryData = Expense::selectRaw('categories.name, categories.color, SUM(expenses.amount) as total')
            ->join('categories', 'expenses.category_id', '=', 'categories.id')
            ->where('expenses.user_id', $user->id)
            ->whereMonth('expenses.expense_date', Carbon::now()->month)
            ->whereYear('expenses.expense_date', Carbon::now()->year)
            ->groupBy('categories.id', 'categories.name', 'categories.color')
            ->get();

        $categoryLabels = $categoryData->pluck('name')->toArray();
        $categoryAmounts = $categoryData->pluck('total')->toArray();
        $categoryColors = $categoryData->pluck('color')->toArray();

        // 7-Day Spending Trend (Line Chart)
        $last7Days = [];
        $trendData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $last7Days[] = $date->format('D'); // Mon, Tue, Wed...

            $dayTotal = Expense::where('user_id', $user->id)
                ->whereDate('expense_date', $date->toDateString())
                ->sum('amount');

            $trendData[] = $dayTotal;
        }

        return view('livewire.dashboard', [
            'today' => $today,
            'thisWeek' => $thisWeek,
            'thisMonth' => $thisMonth,
            'thisYear' => $thisYear,
            'todayTransactions' => $todayTransactions,
            'thisWeekTransactions' => $thisWeekTransactions,
            'thisMonthTransactions' => $thisMonthTransactions,
            'thisYearTransactions' => $thisYearTransactions,
            'recentExpenses' => $recentExpenses,
            // Chart data
            'categoryLabels' => $categoryLabels,
            'categoryAmounts' => $categoryAmounts,
            'categoryColors' => $categoryColors,
            'trendLabels' => $last7Days,
            'trendData' => $trendData,
        ]);
    }
}
