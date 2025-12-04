<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ThemeToggle extends Component
{
    public $theme;

    public function mount()
    {
        $this->theme = Auth::user()->theme ?? 'light';
    }

    public function toggleTheme()
    {
        $this->theme = $this->theme === 'light' ? 'dark' : 'light';

        Auth::user()->update([
            'theme' => $this->theme
        ]);
    }

    public function render()
    {
        return view('livewire.theme-toggle');
    }
}
