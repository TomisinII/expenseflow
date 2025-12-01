<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Create extends Component
{
    public $name = '';
    public $icon = '🍔';
    public $color = '#EF4444';

    public $availableIcons = [
        '🍔', '🚗', '🎮', '💡', '🛒',
        '💊', '✈️', '🏠', '📦', '🎬',
        '☕', '🎵', '💪', '🐕', '💻',
        '📱', '👕', '🎨', '🔧', '💼',
    ];

    public $availableColors = [
        '#EF4444', '#F97316', '#F59E0B', '#84CC16', '#10B981',
        '#14B8A6', '#06B6D4', '#3B82F6', '#6366F1', '#8B5CF6',
        '#A855F7', '#EC4899',
    ];

    protected $rules = [
        'name' => 'required|string|max:100',
        'icon' => 'required|string|max:50',
        'color' => 'required|string|max:20',
    ];

    public function save()
    {
        $this->validate();

        Category::create([
            'user_id' => Auth::id(),
            'name' => $this->name,
            'icon' => $this->icon,
            'color' => $this->color,
        ]);

        $this->reset(['name', 'icon', 'color']);
        $this->icon = '🍔';
        $this->color = '#EF4444';

        // Close modal
        $this->dispatch('close-modal', 'add-category');

        // Refresh category list
        $this->dispatch('category-created');

        // Show success message
        $this->dispatch('message', 'Category created successfully!');

        $this->dispatch('scroll-to-top');
    }

    public function render()
    {
        return view('livewire.categories.create');
    }
}
