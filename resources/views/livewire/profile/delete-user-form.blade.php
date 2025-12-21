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
    <div class="flex items-center justify-between gap-4">
        <div>
            <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100">Delete Account</h4>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                Permanently delete your account and all data
            </p>
        </div>

        <x-danger-button
            type="button"
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
            Delete
        </x-danger-button>
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
                <x-input-label for="password" :value="('Password')" />
                <x-text-input
                    wire:model="password"
                    id="password"
                    type="password"
                    placeholder="Enter your password"
                />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button
                    type="button"
                    x-on:click="$dispatch('close')">
                    Cancel
                </x-secondary-button>

                <x-danger-button
                    type="submit">
                    Delete Account
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
