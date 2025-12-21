<?php

namespace App\Livewire\Expenses;

use App\Models\Category;
use App\Models\Expense;
use App\Services\BudgetCheckerService;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Create extends Component
{
    public $amount;
    public $category_id;
    public $expense_date;
    public $description;
    public $payment_method;
    public $notes;

    protected NotificationService $notificationService;
    protected BudgetCheckerService $budgetChecker;

    protected $messages = [
        'amount.required' => 'Please enter an amount',
        'amount.min' => 'Amount must be greater than 0',
        'category_id.required' => 'Please select a category',
        'expense_date.required' => 'Please select a date',
        'description.required' => 'Please enter a description',
        'payment_method.required' => 'Please select a payment method',
    ];

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

    public function mount()
    {
        // Set default date to today
        $this->expense_date = Carbon::today()->format('Y-m-d');
    }

    public function save()
    {
        $this->validate();

        $expense = Expense::create([
            'user_id' => Auth::id(),
            'amount' => $this->amount,
            'category_id' => $this->category_id,
            'expense_date' => $this->expense_date,
            'description' => $this->description,
            'payment_method' => $this->payment_method,
            'notes' => $this->notes,
        ]);

        // Create success notification
        $this->notificationService->expenseCreated(Auth::user(), $expense);

        $this->dispatch('notification-created');

        // Check budget and create alerts if needed
        $this->budgetChecker->checkBudgetAfterExpense($expense);

        // Reset form
        $this->reset(['amount', 'category_id', 'description', 'payment_method', 'notes']);
        $this->expense_date = Carbon::today()->format('Y-m-d');

        // Show success message
        $this->dispatch('message', 'Expense added successfully!');

        // Refresh the dashboard
        $this->dispatch('expense-created');

        // Close modal
        $this->dispatch('close-modal', 'add-expense');

        // Scroll to top
        $this->dispatch('scroll-to-top');
    }

    public function render()
    {
        return view('livewire.expenses.create', [
            'categories' => Category::where('user_id', Auth::id())->orderBy('name')->get(),
        ]);
    }
}
