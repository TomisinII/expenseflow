<?php

use App\Livewire\Analytics;
use App\Livewire\Dashboard;
use App\Livewire\Expenses;
use App\Livewire\Categories;
use App\Livewire\Budgets;
use App\Livewire\Landing;
use Illuminate\Support\Facades\Route;

Route::get('/', Landing::class)
    ->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', Dashboard::class)
        ->name('dashboard');
    Route::get('expenses', Expenses\Index::class)
        ->name('expenses.index');
    Route::get('categories', Categories\Index::class)
        ->name('categories.index');
    Route::get('budgets', Budgets\Index::class)
        ->name('budgets.index');
    Route::get('analytics', Analytics::class)
        ->name('analytics');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
