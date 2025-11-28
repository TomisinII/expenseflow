<?php

use App\Livewire\Dashboard;
use App\Livewire\Expenses;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('dashboard', Dashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('expenses', Expenses\Index::class)
    ->middleware(['auth', 'verified'])
    ->name('expenses.index');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
