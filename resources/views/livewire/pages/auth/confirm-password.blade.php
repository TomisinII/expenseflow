<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $password = '';

    /**
     * Confirm the current user's password.
     */
    public function confirmPassword(): void
    {
        $this->validate([
            'password' => ['required', 'string'],
        ]);

        if (! Auth::guard('web')->validate([
            'email' => Auth::user()->email,
            'password' => $this->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        session(['auth.password_confirmed_at' => time()]);

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="min-h-screen flex">
    {{-- Left Column - Branding --}}
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-indigo-600 via-purple-600 to-indigo-800 p-12 flex-col justify-between relative overflow-hidden">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full translate-x-1/2 translate-y-1/2"></div>
        </div>

        {{-- Content --}}
        <div class="relative z-10">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center space-x-3 text-white">
                <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                    <span class="text-2xl font-bold">E</span>
                </div>
                <span class="text-2xl font-bold">ExpenseFlow</span>
            </a>

            {{-- Main Content --}}
            <div class="mt-16">
                <h1 class="text-4xl font-bold text-white mb-6">
                    Secure Area
                </h1>
                <p class="text-xl text-indigo-100 mb-8">
                    You're accessing a sensitive part of your account. We need to verify it's really you before continuing.
                </p>

                {{-- Security Features --}}
                <div class="space-y-4">
                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold">Enhanced Security</h3>
                            <p class="text-indigo-200 text-sm">Extra verification for sensitive operations</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold">Protect Your Data</h3>
                            <p class="text-indigo-200 text-sm">Your financial information stays secure</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold">Quick Confirmation</h3>
                            <p class="text-indigo-200 text-sm">Just enter your password to continue</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Right Column - Password Confirmation Form --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gray-50">
        <div class="w-full max-w-md">
            {{-- Mobile Logo (visible only on small screens) --}}
            <div class="lg:hidden mb-8">
                <a href="{{ route('home') }}" class="flex items-center space-x-2 justify-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-xl">E</span>
                    </div>
                    <span class="text-2xl font-bold text-gray-900">ExpenseFlow</span>
                </a>
            </div>

            {{-- Form Header --}}
            <div class="mb-8">
                <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900">Confirm your password</h2>
                <p class="mt-2 text-gray-600">
                    This is a secure area of the application. Please confirm your password before continuing.
                </p>
            </div>

            {{-- Confirmation Form --}}
            <form wire:submit="confirmPassword" class="space-y-6">
                {{-- Password --}}
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input
                        wire:model="password"
                        id="password"
                        class="block mt-1 w-full"
                        type="password"
                        name="password"
                        required
                        autofocus
                        autocomplete="current-password"
                        placeholder="Enter your password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                {{-- Submit Button --}}
                <div>
                    <x-primary-button type="submit" class="w-full justify-center">
                        Confirm
                    </x-primary-button>
                </div>
            </form>

            {{-- Help Text --}}
            <div class="mt-6 p-4 bg-yellow-50 rounded-lg border border-yellow-100">
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <div class="text-sm text-yellow-800">
                        <p class="font-semibold mb-1">Security checkpoint</p>
                        <p class="text-yellow-700">For your protection, we ask you to confirm your identity when accessing sensitive settings or performing important actions.</p>
                    </div>
                </div>
            </div>

            {{-- Additional Link --}}
            <div class="mt-6 text-center">
                <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-semibold" wire:navigate>
                    Forgot your password?
                </a>
            </div>

            {{-- Back to Dashboard Link --}}
            <div class="mt-8 text-center">
                <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900" wire:navigate>
                    ← Back to dashboard
                </a>
            </div>
        </div>
    </div>
</div>
