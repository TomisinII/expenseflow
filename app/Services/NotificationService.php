<?php

namespace App\Services;

use App\Models\User;
use App\Models\Expense;
use App\Models\Category;
use App\Models\Budget;
use App\Models\Notification;

class NotificationService
{
    public function expenseCreated(User $user, Expense $expense): Notification
    {
        return $this->createNotification($user, [
            'type' => 'success',
            'title' => 'Expense Created',
            'message' => sprintf(
                'Added ₦%s for %s',
                number_format($expense->amount, 2),
                $expense->category->name ?? 'Uncategorized'
            ),
            'data' => [
                'expense_id' => $expense->id,
                'category_id' => $expense->category_id,
                'action' => 'created',
            ],
        ]);
    }

    public function expenseUpdated(User $user, Expense $expense): Notification
    {
        return $this->createNotification($user, [
            'type' => 'info',
            'title' => 'Expense Updated',
            'message' => sprintf(
                'Updated %s - ₦%s',
                $expense->category->name ?? 'Uncategorized',
                number_format($expense->amount, 2)
            ),
            'data' => [
                'expense_id' => $expense->id,
                'category_id' => $expense->category_id,
                'action' => 'updated',
            ],
        ]);
    }

    public function expenseDeleted(User $user, array $expense): Notification
    {
        return $this->createNotification($user, [
            'type' => 'info',
            'title' => 'Expense Deleted',
            'message' => sprintf(
                'Deleted ₦%s - %s',
                number_format($expense['amount'], 2),
                $expense['category_name'] ?? 'Uncategorized'
            ),
            'data' => [
                'action' => 'deleted',
            ],
        ]);
    }

    public function categoryCreated(User $user, Category $category): Notification
    {
        return $this->createNotification($user, [
            'type' => 'success',
            'title' => 'Category Created',
            'message' => sprintf('Added new category: %s', $category->name),
            'data' => [
                'category_id' => $category->id,
                'action' => 'created',
            ],
        ]);
    }

    public function budgetCreated(User $user, Budget $budget): Notification
    {
        return $this->createNotification($user, [
            'type' => 'success',
            'title' => 'Budget Created',
            'message' => sprintf(
                'Set ₦%s budget for %s',
                number_format($budget->amount, 2),
                $budget->category->name ?? 'All Categories'
            ),
            'data' => [
                'budget_id' => $budget->id,
                'category_id' => $budget->category_id,
                'action' => 'created',
            ],
        ]);
    }

    public function budgetWarning(User $user, Budget $budget, float $spent, float $percentage): ?Notification
    {
        // Check if we already sent a warning notification in the last hour
        $recentNotification = $user->notifications()
            ->where('type', 'warning')
            ->where('data->budget_id', $budget->id)
            ->where('created_at', '>', now()->subHour())
            ->exists();

        if ($recentNotification) {
            return null; // Don't spam
        }

        return $this->createNotification($user, [
            'type' => 'warning',
            'title' => 'Budget Alert',
            'message' => sprintf(
                "You've spent ₦%s (%.0f%%) of your ₦%s %s budget",
                number_format($spent, 2),
                $percentage,
                number_format($budget->amount, 2),
                $budget->category->name ?? 'monthly'
            ),
            'data' => [
                'budget_id' => $budget->id,
                'category_id' => $budget->category_id,
                'spent' => $spent,
                'budget_amount' => $budget->amount,
                'percentage' => $percentage,
                'action' => 'warning',
            ],
        ]);
    }

    public function budgetExceeded(User $user, Budget $budget, float $spent, float $percentage): ?Notification
    {
        // Check if we already sent an exceeded notification in the last hour
        $recentNotification = $user->notifications()
            ->where('type', 'danger')
            ->where('data->budget_id', $budget->id)
            ->where('created_at', '>', now()->subHour())
            ->exists();

        if ($recentNotification) {
            return null; // Don't spam
        }

        return $this->createNotification($user, [
            'type' => 'danger',
            'title' => 'Budget Exceeded!',
            'message' => sprintf(
                "You've spent ₦%s (%.0f%%) of your ₦%s %s budget",
                number_format($spent, 2),
                $percentage,
                number_format($budget->amount, 2),
                $budget->category->name ?? 'monthly'
            ),
            'data' => [
                'budget_id' => $budget->id,
                'category_id' => $budget->category_id,
                'spent' => $spent,
                'budget_amount' => $budget->amount,
                'percentage' => $percentage,
                'action' => 'exceeded',
            ],
        ]);
    }

    public function markAsRead(Notification $notification): void
    {
        $notification->markAsRead();
    }


    public function markAllAsRead(User $user): int
    {
        return $user->notifications()
            ->unread()
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
    }

    public function deleteOldNotifications(User $user, int $days = 30): int
    {
        return $user->notifications()
            ->where('created_at', '<', now()->subDays($days))
            ->delete();
    }

    protected function createNotification(User $user, array $data): Notification
    {
        return $user->notifications()->create($data);
    }
}
