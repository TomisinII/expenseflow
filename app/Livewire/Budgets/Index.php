<?php

namespace App\Livewire\Budgets;

use App\Models\Budget;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    public $selectedMonth;
    public $selectedYear;
    public $months = [
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December',
    ];

    public function mount()
    {
        $this->selectedMonth = Carbon::now()->month;
        $this->selectedYear = Carbon::now()->year;
    }

    #[On('budget-created')]
    #[On('budget-updated')]
    public function refresh()
    {
        $this->render();
    }

    public function delete($id)
    {
        $budget = Budget::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if ($budget) {
            $budget->delete();
            $this->dispatch('message', 'Budget deleted successfully!');
        }
    }

    public function getBudgetStatus($spent, $budgetAmount)
    {
        $percentage = ($spent / $budgetAmount) * 100;

        if ($percentage >= 100) {
            return 'over-budget';
        } elseif ($percentage >= 85) {
            return 'near-limit';
        } else {
            return 'on-track';
        }
    }

    public function render()
    {
        $user = Auth::user();

        // Get budgets for selected month/year
        $budgets = Budget::with('category')
            ->where('user_id', $user->id)
            ->where('month', $this->selectedMonth)
            ->where('year', $this->selectedYear)
            ->get();

        // Calculate spending for each budget
        $budgetsWithSpending = $budgets->map(function ($budget) {
            $spent = Expense::where('user_id', Auth::id())
                ->where('category_id', $budget->category_id)
                ->whereMonth('expense_date', $this->selectedMonth)
                ->whereYear('expense_date', $this->selectedYear)
                ->sum('amount');

            $budget->spent = $spent;
            $budget->remaining = $budget->amount - $spent;
            $budget->percentage = $budget->amount > 0 ? ($spent / $budget->amount) * 100 : 0;
            $budget->status = $this->getBudgetStatus($spent, $budget->amount);

            return $budget;
        });

        // Calculate totals
        $totalAllocated = $budgets->sum('amount');
        $totalSpent = $budgetsWithSpending->sum('spent');
        $totalRemaining = $totalAllocated - $totalSpent;

        return view('livewire.budgets.index', [
            'budgets' => $budgetsWithSpending,
            'totalAllocated' => $totalAllocated,
            'totalSpent' => $totalSpent,
            'totalRemaining' => $totalRemaining,
            'months' => $this->months,
        ]);
    }
}
