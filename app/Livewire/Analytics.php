<?php

namespace App\Livewire;

use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Analytics extends Component
{
    public $period = 'this_week';
    public $startDate = null;
    public $endDate = null;
    public $showDatePicker = false;

    private function setDefaultDates()
    {
        match($this->period) {
            'this_week' => [
                $this->startDate = Carbon::now()->startOfWeek()->format('Y-m-d'),
                $this->endDate = Carbon::now()->endOfWeek()->format('Y-m-d')
            ],
            'this_month' => [
                $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d'),
                $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d')
            ],
            '3_months' => [
                $this->startDate = Carbon::now()->subMonths(3)->startOfMonth()->format('Y-m-d'),
                $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d')
            ],
            default => null
        };
    }

    public function mount()
    {
        $this->setDefaultDates();
    }

    public function updatedPeriod($value)
    {
        if ($value === 'custom') {
            $this->showDatePicker = true;
        } else {
            $this->showDatePicker = false;
            $this->setDefaultDates();
        }
    }

    public function applyCustomRange()
    {
        if ($this->startDate && $this->endDate) {
            $this->showDatePicker = false;
        }
    }

    public function getAnalyticsData()
    {
        if (!$this->startDate || !$this->endDate) {
            return null;
        }

        $userId = Auth::id();

        // Total spent
        $totalSpent = Expense::where('user_id', $userId)
            ->whereBetween('expense_date', [$this->startDate, $this->endDate])
            ->sum('amount');

        // Daily average
        $days = Carbon::parse($this->startDate)->diffInDays(Carbon::parse($this->endDate)) + 1;
        $dailyAverage = $days > 0 ? $totalSpent / $days : 0;

        // Top category
        $topCategory = Expense::select('categories.name', DB::raw('SUM(expenses.amount) as total'))
            ->join('categories', 'expenses.category_id', '=', 'categories.id')
            ->where('expenses.user_id', $userId)
            ->whereBetween('expenses.expense_date', [$this->startDate, $this->endDate])
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total')
            ->first();

        // Spending by category (for pie chart)
        $categoryBreakdown = Expense::select(
            'categories.name',
            'categories.color',
            DB::raw('SUM(expenses.amount) as total'),
            DB::raw('ROUND((SUM(expenses.amount) / ' . ($totalSpent ?: 1) . ' * 100), 1) as percentage')
        )
            ->join('categories', 'expenses.category_id', '=', 'categories.id')
            ->where('expenses.user_id', $userId)
            ->whereBetween('expenses.expense_date', [$this->startDate, $this->endDate])
            ->groupBy('categories.id', 'categories.name', 'categories.color')
            ->orderByDesc('total')
            ->get();

        // Daily spending trend
        $dailyTrend = Expense::select(
            DB::raw('DATE(expense_date) as date'),
            DB::raw('SUM(amount) as total')
        )
            ->where('user_id', $userId)
            ->whereBetween('expense_date', [$this->startDate, $this->endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top 10 expenses
        $topExpenses = Expense::where('user_id', $userId)
            ->whereBetween('expense_date', [$this->startDate, $this->endDate])
            ->orderByDesc('amount')
            ->limit(10)
            ->get();

        return [
            'totalSpent' => $totalSpent,
            'dailyAverage' => $dailyAverage,
            'topCategory' => $topCategory,
            'categoryBreakdown' => $categoryBreakdown,
            'dailyTrend' => $dailyTrend,
            'topExpenses' => $topExpenses,
        ];
    }

    public function exportReport()
    {
        // Export functionality to be implemented
        $this->dispatch('notify', message: 'Export feature coming soon!');
    }

    public function render()
    {
        $analytics = $this->getAnalyticsData();

        return view('livewire.analytics', [
            'analytics' => $analytics
        ]);
    }
}
