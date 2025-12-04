<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component
{
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public $avatar;
    public $currentAvatar;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->currentAvatar = Auth::user()->avatar;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        // Handle avatar upload
        if ($this->avatar) {
            // Delete old avatar if exists
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $this->avatar->store('avatars', 'public');
            $user->avatar = $path;
            $this->currentAvatar = $path;
        }

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
        $this->avatar = null; // Reset file input
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));
            return;
        }

        $user->sendEmailVerificationNotification();
        session()->flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <form wire:submit="updateProfileInformation" class="space-y-6">
        <!-- Profile Picture Section -->
        <div class="flex items-start gap-6">
            <div class="flex flex-col items-center gap-3">
                <div class="relative">
                    @if($currentAvatar)
                        <img
                            src="{{ Storage::url($currentAvatar) }}"
                            alt="Profile"
                            class="w-20 h-20 rounded-full object-cover border-4 border-gray-100 dark:border-gray-700">
                    @else
                        <div class="w-20 h-20 rounded-full bg-indigo-600 flex items-center justify-center">
                            <svg class="w-10 h-10 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor">
                                <path d="M234-276q51-39 114-61.5T480-360q69 0 132 22.5T726-276q35-41 54.5-93T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 59 19.5 111t54.5 93Zm246-164q-59 0-99.5-40.5T340-580q0-59 40.5-99.5T480-720q59 0 99.5 40.5T620-580q0 59-40.5 99.5T480-440Zm0 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Z"/>
                            </svg>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex-1">
                <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100">Profile Picture</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 mb-3">
                    Upload a photo to personalize your account
                </p>

                <label for="avatar-upload" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 font-medium cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor">
                        <path d="M480-260q75 0 127.5-52.5T660-440q0-75-52.5-127.5T480-620q-75 0-127.5 52.5T300-440q0 75 52.5 127.5T480-260Zm0-80q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM160-120q-33 0-56.5-23.5T80-200v-480q0-33 23.5-56.5T160-760h126l74-80h240l74 80h126q33 0 56.5 23.5T880-680v480q0 33-23.5 56.5T800-120H160Z"/>
                    </svg>
                    Change Photo
                </label>
                <input
                    id="avatar-upload"
                    type="file"
                    wire:model="avatar"
                    accept="image/*"
                    class="hidden">

                @if($avatar)
                    <p class="text-xs text-green-600 dark:text-green-400 mt-2">
                        New photo selected. Click "Save Changes" to upload.
                    </p>
                @endif

                <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
            </div>
        </div>

        <!-- Full Name -->
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-900 dark:text-gray-100 mb-2">
                Full Name
            </label>
            <input
                wire:model="name"
                id="name"
                type="text"
                required
                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-900 dark:text-gray-100 mb-2">
                Email Address
            </label>
            <input
                wire:model="email"
                id="email"
                type="email"
                required
                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div class="mt-3 p-3 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg">
                    <p class="text-sm text-amber-800 dark:text-amber-200">
                        Your email address is unverified.
                        <button
                            wire:click.prevent="sendVerification"
                            type="button"
                            class="underline font-medium hover:no-underline">
                            Click here to re-send the verification email.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm font-medium text-green-600 dark:text-green-400">
                            A new verification link has been sent to your email address.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Save Button -->
        <div class="flex items-center gap-4">
            <button
                type="submit"
                class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                Save Changes
            </button>

            <div
                x-data="{ show: false }"
                x-on:profile-updated.window="show = true; setTimeout(() => show = false, 2000)"
                x-show="show"
                x-transition
                class="text-sm text-green-600 dark:text-green-400 font-medium">
                Saved successfully!
            </div>
        </div>
    </form>
</section>
