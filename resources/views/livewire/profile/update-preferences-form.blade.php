<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public bool $darkMode = false;
    public bool $budgetNotifications = true;
    public bool $weeklyReports = true;

    public function mount(): void
    {
        $user = Auth::user();
        $this->darkMode = $user->theme === 'dark';
        $this->budgetNotifications = $user->budget_notifications ?? true;
        $this->weeklyReports = $user->weekly_reports ?? true;
    }

    public function updatedDarkMode(): void
    {
        $user = Auth::user();
        $user->theme = $this->darkMode ? 'dark' : 'light';
        $user->save();

        // Dispatch event to update theme globally
        $this->dispatch('theme-changed', theme: $user->theme);

        // Reload page to apply theme change
        $this->js('window.location.reload()');
    }

    public function updatedBudgetNotifications(): void
    {
        $user = Auth::user();
        $user->budget_notifications = $this->budgetNotifications;
        $user->save();

        $this->dispatch('preference-updated');
    }

    public function updatedWeeklyReports(): void
    {
        $user = Auth::user();
        $user->weekly_reports = $this->weeklyReports;
        $user->save();

        $this->dispatch('preference-updated');
    }
}; ?>

<section>
    <div class="space-y-6">
        <!-- Dark Mode Toggle -->
        <div class="flex items-center justify-between">
            <div>
                <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100">Dark Mode</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Enable dark theme for better viewing at night
                </p>
            </div>
            <button
                type="button"
                wire:click="$toggle('darkMode')"
                class="relative inline-flex h-6 w-11 items-center rounded-full transition {{ $darkMode ? 'bg-indigo-600' : 'bg-gray-300 dark:bg-gray-600' }}">
                <span class="inline-block h-4 w-4 transform rounded-full bg-white transition {{ $darkMode ? 'translate-x-6' : 'translate-x-1' }}"></span>
            </button>
        </div>

        <!-- Budget Notifications Toggle -->
        <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
            <div>
                <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100">Budget Notifications</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Get alerts when approaching budget limits
                </p>
            </div>
            <button
                type="button"
                wire:click="$toggle('budgetNotifications')"
                class="relative inline-flex h-6 w-11 items-center rounded-full transition {{ $budgetNotifications ? 'bg-indigo-600' : 'bg-gray-300 dark:bg-gray-600' }}">
                <span class="inline-block h-4 w-4 transform rounded-full bg-white transition {{ $budgetNotifications ? 'translate-x-6' : 'translate-x-1' }}"></span>
            </button>
        </div>

        <!-- Weekly Reports Toggle -->
        <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
            <div>
                <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100">Weekly Reports</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Receive weekly spending summary via email
                </p>
            </div>
            <button
                type="button"
                wire:click="$toggle('weeklyReports')"
                class="relative inline-flex h-6 w-11 items-center rounded-full transition {{ $weeklyReports ? 'bg-indigo-600' : 'bg-gray-300 dark:bg-gray-600' }}">
                <span class="inline-block h-4 w-4 transform rounded-full bg-white transition {{ $weeklyReports ? 'translate-x-6' : 'translate-x-1' }}"></span>
            </button>
        </div>

        <!-- Success Message -->
        <div
            x-data="{ show: false }"
            x-on:preference-updated.window="show = true; setTimeout(() => show = false, 2000)"
            x-show="show"
            x-transition
            class="text-sm text-green-600 dark:text-green-400 font-medium">
            Preference updated successfully!
        </div>
    </div>
</section>
