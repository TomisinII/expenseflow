<?php

namespace App\Livewire\Expenses;

use App\Models\Expense;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $showCreateModal = false;

    public function openCreateModal()
    {
        $this->showCreateModal = true;
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
    }

    public function delete($id)
    {
        $expense = Expense::where('user_id', auth()->id())->findOrFail($id);
        $expense->delete();

        session()->flash('message', 'Expense deleted successfully.');
    }

    public function render()
    {
        $expenses = Expense::with('category')
            ->where('user_id', auth()->id())
            ->when($this->search, function($query) {
                $query->where('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy('expense_date', 'desc')
            ->paginate(20);

        return view('livewire.expenses.index', [
            'expenses' => $expenses,
        ]);
    }
}
