<?php

namespace App\Livewire\Expenses;

use App\Models\Category;
use App\Models\Expense;
use App\Services\BudgetCheckerService;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Edit extends Component
{
    public $expenseId;
    public $amount;
    public $category_id;
    public $expense_date;
    public $description;
    public $payment_method;
    public $notes;

    protected NotificationService $notificationService;
    protected BudgetCheckerService $budgetChecker;

    public function boot(
        NotificationService $notificationService,
        BudgetCheckerService $budgetChecker
    ) {
        $this->notificationService = $notificationService;
        $this->budgetChecker = $budgetChecker;
    }

    protected $rules = [
        'amount' => 'required|numeric|min:0.01',
        'category_id' => 'required|exists:categories,id',
        'expense_date' => 'required|date',
        'description' => 'required|string|max:255',
        'payment_method' => 'required|in:cash,card,bank_transfer,other',
        'notes' => 'nullable|string|max:1000',
    ];

    protected $messages = [
        'amount.required' => 'Please enter an amount',
        'amount.min' => 'Amount must be greater than 0',
        'category_id.required' => 'Please select a category',
        'expense_date.required' => 'Please select a date',
        'description.required' => 'Please enter a description',
        'payment_method.required' => 'Please select a payment method',
    ];

    #[On('edit-expense')]
    public function loadExpense($expenseId)
    {
        $this->expenseId = $expenseId;

        $expense = Expense::where('id', $expenseId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$expense) {
            session()->flash('error', 'Expense not found.');
            return;
        }

        $this->amount = $expense->amount;
        $this->category_id = $expense->category_id;
        $this->expense_date = $expense->expense_date->format('Y-m-d');
        $this->description = $expense->description;
        $this->payment_method = $expense->payment_method;
        $this->notes = $expense->notes;

        // Open the modal
        $this->dispatch('open-modal', 'edit-expense');
    }

    public function save()
    {
        $this->validate();

        $expense = Expense::where('id', $this->expenseId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $expense->update([
            'amount' => $this->amount,
            'category_id' => $this->category_id,
            'expense_date' => $this->expense_date,
            'description' => $this->description,
            'payment_method' => $this->payment_method,
            'notes' => $this->notes,
        ]);

        // Refresh the expense model to get updated data
        $expense->refresh();

        // Create update notification
        $this->notificationService->expenseUpdated(Auth::user(), $expense);

        $this->dispatch('notification-created');

        // Re-check budget (amount or category might have changed)
        $this->budgetChecker->checkBudgetAfterExpense($expense);

        // Close modal
        $this->dispatch('close-modal', 'edit-expense');

        // Show success message
        $this->dispatch('message', 'Expense updated successfully!');

        // Refresh the dashboard
        $this->dispatch('expense-updated');

        // Scroll to top
        $this->dispatch('scroll-to-top');
    }

    public function render()
    {
        return view('livewire.expenses.edit', [
            'categories' => Category::where('user_id', Auth::id())
                ->orderBy('name')
                ->get()
        ]);
    }
}
