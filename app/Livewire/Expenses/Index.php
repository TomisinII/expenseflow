<?php

namespace App\Livewire\Expenses;

use App\Models\Category;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    // Filter properties (temporary - not applied until button clicked)
    public $filterCategory = '';
    public $filterFromDate = '';
    public $filterToDate = '';
    public $filterPaymentMethod = '';
    public $filterMinAmount = '';
    public $filterMaxAmount = '';

    // Applied filter properties (actually used in query)
    public $appliedFilterCategory = '';
    public $appliedFilterFromDate = '';
    public $appliedFilterToDate = '';
    public $appliedFilterPaymentMethod = '';
    public $appliedFilterMinAmount = '';
    public $appliedFilterMaxAmount = '';

    /**
     * Get the filtered expenses query (reusable for both display and export)
     */
    private function getFilteredExpensesQuery()
    {
        return Expense::with('category')
            ->where('user_id', Auth::id())
            ->when($this->search, function($query) {
                $query->where('description', 'like', '%' . $this->search . '%')
                      ->orWhereHas('category', function($q) {
                          $q->where('name', 'like', '%' . $this->search . '%');
                      });
            })
            ->when($this->appliedFilterCategory, function($query) {
                $query->where('category_id', $this->appliedFilterCategory);
            })
            ->when($this->appliedFilterFromDate, function($query) {
                $query->whereDate('expense_date', '>=', $this->appliedFilterFromDate);
            })
            ->when($this->appliedFilterToDate, function($query) {
                $query->whereDate('expense_date', '<=', $this->appliedFilterToDate);
            })
            ->when($this->appliedFilterPaymentMethod, function($query) {
                $query->where('payment_method', $this->appliedFilterPaymentMethod);
            })
            ->when($this->appliedFilterMinAmount, function($query) {
                $query->where('amount', '>=', $this->appliedFilterMinAmount);
            })
            ->when($this->appliedFilterMaxAmount, function($query) {
                $query->where('amount', '<=', $this->appliedFilterMaxAmount);
            })
            ->orderBy('expense_date', 'desc');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function applyFilters()
    {
        $this->appliedFilterCategory = $this->filterCategory;
        $this->appliedFilterFromDate = $this->filterFromDate;
        $this->appliedFilterToDate = $this->filterToDate;
        $this->appliedFilterPaymentMethod = $this->filterPaymentMethod;
        $this->appliedFilterMinAmount = $this->filterMinAmount;
        $this->appliedFilterMaxAmount = $this->filterMaxAmount;

        $this->resetPage();
        $this->dispatch('close-filters');
    }

    public function resetFilters()
    {
        // Reset both temporary and applied filters
        $this->filterCategory = '';
        $this->filterFromDate = '';
        $this->filterToDate = '';
        $this->filterPaymentMethod = '';
        $this->filterMinAmount = '';
        $this->filterMaxAmount = '';

        $this->appliedFilterCategory = '';
        $this->appliedFilterFromDate = '';
        $this->appliedFilterToDate = '';
        $this->appliedFilterPaymentMethod = '';
        $this->appliedFilterMinAmount = '';
        $this->appliedFilterMaxAmount = '';

        $this->resetPage();
    }

    public function exportCsv(){
        // Get the filtered expenses query (without pagination)
        $expenses = $this->getFilteredExpensesQuery()->get();

        // Generate filename with current date
        $filename = 'expenses_' . now()->format('Y-m-d_His') . '.csv';

        // Create a streamed response
        return response()->streamDownload(function () use ($expenses) {
            $handle = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($handle, [
                'Date',
                'Description',
                'Category',
                'Payment Method',
                'Amount (₦)',
                'Notes'
            ]);

            // Add expense data
            foreach ($expenses as $expense) {
                fputcsv($handle, [
                    $expense->expense_date->format('Y-m-d'),
                    $expense->description,
                    $expense->category->name ?? 'N/A',
                    ucwords(str_replace('_', ' ', $expense->payment_method)),
                    number_format($expense->amount, 2, '.', ''),
                    $expense->notes ?? ''
                ]);
            }

            // Add summary row
            fputcsv($handle, []);
            fputcsv($handle, [
                'Total Expenses:',
                $expenses->count(),
                '',
                '',
                number_format($expenses->sum('amount'), 2, '.', ''),
                ''
            ]);

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);

    }

    public function edit($id)
    {
        $this->dispatch('edit-expense', ['expenseId' => $id]);
    }

    public function delete($id)
    {
        $user = Auth::user();
        $expense = Expense::where('id', $id)->where('user_id', $user->id)->first();

        if ($expense) {
            $expense->delete();
            $this->dispatch('message', 'Expense deleted successfully!');
        } else {
            $this->dispatch('message', 'Expense not found or unauthorized.');
        }
    }

    public function render()
    {
       $expenses = Expense::with('category')
            ->where('user_id', Auth::id())
            ->when($this->search, function($query) {
                $query->where('description', 'like', '%' . $this->search . '%')
                      ->orWhereHas('category', function($q) {
                          $q->where('name', 'like', '%' . $this->search . '%');
                      });
            })
            ->when($this->appliedFilterCategory, function($query) {
                $query->where('category_id', $this->appliedFilterCategory);
            })
            ->when($this->appliedFilterFromDate, function($query) {
                $query->whereDate('expense_date', '>=', $this->appliedFilterFromDate);
            })
            ->when($this->appliedFilterToDate, function($query) {
                $query->whereDate('expense_date', '<=', $this->appliedFilterToDate);
            })
            ->when($this->appliedFilterPaymentMethod, function($query) {
                $query->where('payment_method', $this->appliedFilterPaymentMethod);
            })
            ->when($this->appliedFilterMinAmount, function($query) {
                $query->where('amount', '>=', $this->appliedFilterMinAmount);
            })
            ->when($this->appliedFilterMaxAmount, function($query) {
                $query->where('amount', '<=', $this->appliedFilterMaxAmount);
            })
            ->orderBy('expense_date', 'desc')
            ->paginate(15);

        $categories = Category::where('user_id', Auth::id())
            ->orderBy('name')
            ->get();

        return view('livewire.expenses.index', [
            'expenses' => $expenses,
            'categories' => $categories,
        ]);
    }
}
