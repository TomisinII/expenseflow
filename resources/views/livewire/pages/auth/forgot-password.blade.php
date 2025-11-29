<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
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
                    Reset Your Password
                </h1>
                <p class="text-xl text-indigo-100 mb-8">
                    Don't worry, it happens to the best of us. We'll send you a link to reset your password and get you back on track.
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
                            <h3 class="text-white font-semibold">Secure Reset Link</h3>
                            <p class="text-indigo-200 text-sm">One-time link sent directly to your email</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold">Quick & Easy</h3>
                            <p class="text-indigo-200 text-sm">Reset your password in just a few clicks</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold">Your Data is Safe</h3>
                            <p class="text-indigo-200 text-sm">All your expenses and data remain secure</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Right Column - Password Reset Form --}}
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
                <h2 class="text-3xl font-bold text-gray-900">Forgot your password?</h2>
                <p class="mt-2 text-gray-600">
                    No problem. Just enter your email address and we'll send you a password reset link.
                </p>
            </div>

            {{-- Session Status --}}
            <x-auth-session-status class="mb-4" :status="session('status')" />

            {{-- Password Reset Form --}}
            <form wire:submit="sendPasswordResetLink" class="space-y-6">
                {{-- Email Address --}}
                <div>
                    <x-input-label for="email" :value="__('Email address')" />
                    <x-text-input
                        wire:model="email"
                        id="email"
                        class="block mt-1 w-full"
                        type="email"
                        name="email"
                        required
                        autofocus
                        placeholder="you@example.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- Submit Button --}}
                <div>
                    <x-primary-button type="submit" class="w-full justify-center">
                        Send reset link
                    </x-primary-button>
                </div>
            </form>

            {{-- Additional Links --}}
            <div class="mt-6 space-y-4">
                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-semibold" wire:navigate>
                        ← Back to sign in
                    </a>
                </div>

                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-gray-50 text-gray-500">Or</span>
                    </div>
                </div>

                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-700 font-semibold" wire:navigate>
                            Create one now
                        </a>
                    </p>
                </div>
            </div>

            {{-- Help Text --}}
            <div class="mt-8 p-4 bg-blue-50 rounded-lg border border-blue-100">
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                    <div class="text-sm text-blue-700">
                        <p class="font-semibold mb-1">Didn't receive the email?</p>
                        <p class="text-blue-600">Check your spam folder or try again with a different email address.</p>
                    </div>
                </div>
            </div>

            {{-- Back to Home Link --}}
            <div class="mt-8 text-center">
                <a href="{{ route('home') }}" class="text-sm text-gray-600 hover:text-gray-900" wire:navigate>
                    ← Back to homepage
                </a>
            </div>
        </div>
    </div>
</div>
