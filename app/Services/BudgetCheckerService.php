<?php

namespace App\Services;

use App\Models\Expense;
use App\Models\Budget;
use Illuminate\Support\Facades\DB;

class BudgetCheckerService
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Check budget thresholds after an expense is created/updated.
     */
    public function checkBudgetAfterExpense(Expense $expense): void
    {
        $user = $expense->user;
        $month = $expense->expense_date->month;
        $year = $expense->expense_date->year;

        // Find budget for this category and month
        $budget = Budget::where('user_id', $user->id)
            ->where('category_id', $expense->category_id)
            ->where('month', $month)
            ->where('year', $year)
            ->first();

        if (!$budget) {
            return; // No budget set for this category/month
        }

        // Calculate total spending for this category in this month
        $spent = $this->calculateCategorySpending(
            $user->id,
            $expense->category_id,
            $month,
            $year
        );

        $percentage = ($spent / $budget->amount) * 100;

        // Trigger notifications based on thresholds
        if ($percentage >= 100) {
            // Budget exceeded (100%+)
            $this->notificationService->budgetExceeded($user, $budget, $spent, $percentage);
        } elseif ($percentage >= 85) {
            // Budget warning (85-99%)
            $this->notificationService->budgetWarning($user, $budget, $spent, $percentage);
        }
    }

    /**
     * Calculate total spending for a category in a specific month.
     */
    public function calculateCategorySpending(
        int $userId,
        int $categoryId,
        int $month,
        int $year
    ): float {
        return DB::table('expenses')
            ->where('user_id', $userId)
            ->where('category_id', $categoryId)
            ->whereMonth('expense_date', $month)
            ->whereYear('expense_date', $year)
            ->whereNull('deleted_at')
            ->sum('amount');
    }

    /**
     * Get budget status for a specific category and month.
     */
    public function getBudgetStatus(int $userId, int $categoryId, int $month, int $year): ?array
    {
        $budget = Budget::where('user_id', $userId)
            ->where('category_id', $categoryId)
            ->where('month', $month)
            ->where('year', $year)
            ->first();

        if (!$budget) {
            return null;
        }

        $spent = $this->calculateCategorySpending($userId, $categoryId, $month, $year);
        $percentage = ($spent / $budget->amount) * 100;
        $remaining = $budget->amount - $spent;

        return [
            'budget' => $budget,
            'spent' => $spent,
            'remaining' => $remaining,
            'percentage' => $percentage,
            'status' => $this->getStatusType($percentage),
        ];
    }

    /**
     * Get status type based on percentage.
     */
    protected function getStatusType(float $percentage): string
    {
        if ($percentage >= 100) {
            return 'exceeded';
        } elseif ($percentage >= 90) {
            return 'warning';
        } elseif ($percentage >= 75) {
            return 'caution';
        }

        return 'safe';
    }

    /**
     * Check all budgets for a user and create notifications if needed.
     * Useful for scheduled tasks or manual checks.
     */
    public function checkAllUserBudgets(int $userId): void
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $budgets = Budget::where('user_id', $userId)
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->with(['user', 'category'])
            ->get();

        foreach ($budgets as $budget) {
            $spent = $this->calculateCategorySpending(
                $userId,
                $budget->category_id,
                $currentMonth,
                $currentYear
            );

            $percentage = ($spent / $budget->amount) * 100;

            if ($percentage >= 100) {
                $this->notificationService->budgetExceeded($budget->user, $budget, $spent, $percentage);
            } elseif ($percentage >= 90) {
                $this->notificationService->budgetWarning($budget->user, $budget, $spent, $percentage);
            }
        }
    }
}
