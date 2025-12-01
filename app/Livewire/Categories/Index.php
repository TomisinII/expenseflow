<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    #[On('saved')]
    #[On('category-created')]
    public function refreshData()
    {
        // This will trigger a re-render of the component
        $this->render();
    }

    public function render()
    {
        $categories = Category::where('user_id', Auth::id())
            ->withCount('expenses')
            ->orderBy('name')
            ->get();

        // Calculate statistics
        $totalExpenses = $categories->sum('expenses_count');
        $categoryStats = $categories->map(function ($category) use ($totalExpenses) {
            return [
                'name' => $category->name,
                'icon' => $category->icon,
                'color' => $category->color,
                'count' => $category->expenses_count,
                'percentage' => $totalExpenses > 0
                    ? round(($category->expenses_count / $totalExpenses) * 100, 1)
                    : 0,
            ];
        })->sortByDesc('count')->take(5);

        return view('livewire.categories.index', [
            'categories' => $categories,
            'categoryStats' => $categoryStats,
        ]);
    }
}
