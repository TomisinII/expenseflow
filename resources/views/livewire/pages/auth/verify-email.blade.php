<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);

            return;
        }

        Auth::user()->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
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
                    Almost There!
                </h1>
                <p class="text-xl text-indigo-100 mb-8">
                    You're just one step away from accessing all the powerful features of ExpenseFlow. Let's verify your email address.
                </p>

                {{-- Why Verify --}}
                <div class="space-y-4">
                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold">Account Security</h3>
                            <p class="text-indigo-200 text-sm">Protect your account from unauthorized access</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold">Important Notifications</h3>
                            <p class="text-indigo-200 text-sm">Receive updates about your expenses and budgets</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold">Account Recovery</h3>
                            <p class="text-indigo-200 text-sm">Easily reset your password if needed</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Right Column - Email Verification --}}
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900">Verify your email</h2>
                <p class="mt-2 text-gray-600">
                    Thanks for signing up! Before getting started, please verify your email address by clicking on the link we just emailed to you.
                </p>
            </div>

            {{-- Success Message --}}
            @if (session('status') == 'verification-link-sent')
                <div class="mb-6 p-4 bg-green-50 rounded-lg border border-green-200">
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <div class="text-sm text-green-800">
                            <p class="font-semibold mb-1">Email sent!</p>
                            <p class="text-green-700">A new verification link has been sent to the email address you provided during registration.</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Action Buttons --}}
            <div class="space-y-4">
                <x-primary-button wire:click="sendVerification" type="button" class="w-full justify-center">
                    Resend verification email
                </x-primary-button>

                <x-secondary-button wire:click="logout" type="button" class="w-full justify-center">
                    Log out
                </x-secondary-button>
            </div>

            {{-- Help Text --}}
            <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-100">
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                    <div class="text-sm text-blue-700">
                        <p class="font-semibold mb-1">Didn't receive the email?</p>
                        <ul class="text-blue-600 space-y-1 list-disc list-inside">
                            <li>Check your spam or junk folder</li>
                            <li>Make sure you entered the correct email</li>
                            <li>Click the button above to resend</li>
                        </ul>
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
