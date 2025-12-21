<?php

namespace App\Livewire\Budgets;

use App\Models\Budget;
use App\Models\Category;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Create extends Component
{
    public $category_id;
    public $amount;
    public $month;
    public $year;

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

    protected NotificationService $notificationService;

    protected $rules = [
        'category_id' => 'required|exists:categories,id',
        'amount' => 'required|numeric|min:1',
        'month' => 'required|integer|min:1|max:12',
        'year' => 'required|integer|min:2020|max:2100',
    ];

    protected $messages = [
        'category_id.required' => 'Please select a category',
        'amount.required' => 'Please enter a budget amount',
        'amount.min' => 'Budget amount must be at least ₦1',
        'month.required' => 'Please select a month',
        'year.required' => 'Please enter a year',
    ];

    public function boot(
        NotificationService $notificationService,
    ) {
        $this->notificationService = $notificationService;
    }

    public function mount()
    {
        $this->month = Carbon::now()->month;
        $this->year = Carbon::now()->year;
    }

    public function save()
    {
        $this->validate();

        // Check if budget already exists for this category/month/year
        $existingBudget = Budget::where('user_id', Auth::id())
            ->where('category_id', $this->category_id)
            ->where('month', $this->month)
            ->where('year', $this->year)
            ->first();

        if ($existingBudget) {
            $this->addError('category_id', 'A budget already exists for this category in the selected month.');
            return;
        }

        $budget = Budget::create([
            'user_id' => Auth::id(),
            'category_id' => $this->category_id,
            'amount' => $this->amount,
            'month' => $this->month,
            'year' => $this->year,
        ]);

        $this->notificationService->budgetCreated(Auth::user(), $budget);

        $this->dispatch('notification-created');

        // Reset form
        $this->reset(['category_id', 'amount']);
        $this->month = Carbon::now()->month;
        $this->year = Carbon::now()->year;

        // Close modal
        $this->dispatch('close-modal', 'add-budget');

        // Show success messages
        $this->dispatch('message', 'Budget created successfully!');

        // Refresh budgets list
        $this->dispatch('budget-created');
    }

    public function render()
    {
        $categories = Category::where('user_id', Auth::id())
            ->orderBy('name')
            ->get();

        return view('livewire.budgets.create', [
            'categories' => $categories,
        ]);
    }
}
