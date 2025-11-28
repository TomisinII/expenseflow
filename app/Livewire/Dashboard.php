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

        $recentExpenses = Expense::with('category')
            ->where('user_id', $user->id)
            ->orderBy('expense_date', 'desc')
            ->take(10)
            ->get();

        return view('livewire.dashboard', [
            'today' => $today,
            'thisWeek' => $thisWeek,
            'thisMonth' => $thisMonth,
            'thisYear' => $thisYear,
            'recentExpenses' => $recentExpenses,
        ]);
    }
}
