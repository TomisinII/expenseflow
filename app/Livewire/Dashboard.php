<?php

namespace App\Livewire;

use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;


class Dashboard extends Component
{
    /**
     * Calculate the change between current and previous values
     * Returns: 'increase', 'decrease', or 'no-change'
     */
    private function calculateChange($current, $previous)
    {
        if ($current > $previous) {
            return 'increase';
        } elseif ($current < $previous) {
            return 'decrease';
        } else {
            return 'no-change';
        }
    }

    #[On('expense-created')]
    #[On('expense-updated')]
    #[On('expense-deleted')]
    public function refreshData()
    {
        // Dispatch event to update charts
        $this->dispatch('refresh-charts');
    }

    public function deleteExpense($expenseId)
    {
        $user = Auth::user();
        $expense = Expense::where('id', $expenseId)->where('user_id', $user->id)->first();

        if ($expense) {
            $expense->delete();
            $this->dispatch('message', 'Expense deleted successfully.');
            $this->dispatch('expense-deleted');
        } else {
            $this->dispatch('error', ['message' => 'Expense not found ors unauthorized.']);
        }
    }

    public function editExpense($expenseId)
    {
        $this->dispatch('edit-expense', ['expenseId' => $expenseId]);
    }

    public function render()
    {
        $user = Auth::user();

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

        // ====== COMPARISON DATA ======

        // Compare with yesterday
        $yesterdayTransactions = Expense::where('user_id', $user->id)
            ->whereDate('expense_date', Carbon::yesterday())
            ->count();

        $todayChange = $this->calculateChange($todayTransactions, $yesterdayTransactions);

        // Compare with last week
        $lastWeekStart = Carbon::now()->subWeek()->startOfWeek();
        $lastWeekEnd = Carbon::now()->subWeek()->endOfWeek();
        $lastWeekTransactions = Expense::where('user_id', $user->id)
            ->whereBetween('expense_date', [$lastWeekStart, $lastWeekEnd])
            ->count();

        $thisWeekChange = $this->calculateChange($thisWeekTransactions, $lastWeekTransactions);

        // Compare with last month
        $lastMonth = Carbon::now()->subMonth();
        $lastMonthTransactions = Expense::where('user_id', $user->id)
            ->whereMonth('expense_date', $lastMonth->month)
            ->whereYear('expense_date', $lastMonth->year)
            ->count();

        $thisMonthChange = $this->calculateChange($thisMonthTransactions, $lastMonthTransactions);

        // Compare with last year
        $lastYear = Carbon::now()->subYear();
        $lastYearTransactions = Expense::where('user_id', $user->id)
            ->whereYear('expense_date', $lastYear->year)
            ->count();

        $thisYearChange = $this->calculateChange($thisYearTransactions, $lastYearTransactions);

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
            // Change data
            'todayChange' => $todayChange,
            'thisWeekChange' => $thisWeekChange,
            'thisMonthChange' => $thisMonthChange,
            'thisYearChange' => $thisYearChange,
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
