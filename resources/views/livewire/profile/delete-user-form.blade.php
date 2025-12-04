<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section>
    <div class="flex items-center justify-between">
        <div>
            <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100">Delete Account</h4>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                Permanently delete your account and all data
            </p>
        </div>

        <button
            type="button"
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="px-6 py-2.5 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition">
            Delete
        </button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="deleteUser" class="p-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                Are you sure you want to delete your account?
            </h2>

            <p class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.
            </p>

            <div class="mt-6">
                <label for="password" class="block text-sm font-semibold text-gray-900 dark:text-gray-100 mb-2">
                    Password
                </label>
                <input
                    wire:model="password"
                    id="password"
                    type="password"
                    placeholder="Enter your password"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-red-500 focus:ring-red-500">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button
                    type="button"
                    x-on:click="$dispatch('close')"
                    class="px-6 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                    Cancel
                </button>

                <button
                    type="submit"
                    class="px-6 py-2.5 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition">
                    Delete Account
                </button>
            </div>
        </form>
    </x-modal>
</section>
