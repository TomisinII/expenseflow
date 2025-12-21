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
            'avatar' => ['nullable', 'image', 'max:2048'], // 2MB max
        ]);

        // Handle avatar upload
        if ($this->avatar) {
            // Delete old avatar if exists and it's not the default
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Store new avatar
            $path = $this->avatar->store('avatars', 'public');
            $validated['avatar'] = $path;
        }

        // Update user
        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        if (isset($validated['avatar'])) {
            $user->avatar = $validated['avatar'];
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Update current avatar and reset the file input after save
        $this->currentAvatar = $user->avatar;
        $this->reset('avatar');

        $this->dispatch('profile-updated', name: $user->name);

        session()->flash('message', 'Profile updated successfully!');
    }

    /**
     * Remove the current avatar
     */
    public function removeAvatar(): void
    {
        $user = Auth::user();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->avatar = null;
        $user->save();

        $this->currentAvatar = null;
        $this->reset('avatar');

        session()->flash('message', 'Avatar removed successfully!');
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

<section x-data="{ confirmingAvatarRemoval: false }">
    <form wire:submit="updateProfileInformation" class="space-y-6">
        <!-- Profile Picture Section -->
        <div class="flex items-start gap-6">
            <div class="flex flex-col items-center gap-3">
                <div class="relative group">
                    @if($avatar)
                        {{-- Preview of new upload --}}
                        <img
                            src="{{ $avatar->temporaryUrl() }}"
                            alt="Preview"
                            class="w-20 h-20 rounded-full object-cover border-4 border-indigo-200 dark:border-indigo-700">
                        <div class="absolute inset-0 bg-black bg-opacity-50 rounded-full flex items-center justify-center">
                            <span class="text-white text-xs font-medium">Preview</span>
                        </div>
                    @elseif($currentAvatar)
                        <img
                            src="{{ asset('storage/' . $currentAvatar) }}"
                            alt="Profile"
                            class="w-20 h-20 rounded-full object-cover border-4 border-gray-100 dark:border-gray-700"
                            onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 -960 960 960%22 fill=%22%236366f1%22%3E%3Cpath d=%22M234-276q51-39 114-61.5T480-360q69 0 132 22.5T726-276q35-41 54.5-93T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 59 19.5 111t54.5 93Zm246-164q-59 0-99.5-40.5T340-580q0-59 40.5-99.5T480-720q59 0 99.5 40.5T620-580q0 59-40.5 99.5T480-440Zm0 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Z%22/%3E%3C/svg%3E';">

                        {{-- Remove button on hover --}}
                        <button
                            type="button"
                            @click="$dispatch('open-modal', 'confirm-avatar-removal')"
                            class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 rounded-full flex items-center justify-center transition-all opacity-0 group-hover:opacity-100">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    @else
                        <div class="w-20 h-20 rounded-full bg-indigo-600 flex items-center justify-center">
                            <svg class="w-10 h-10 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor">
                                <path d="M234-276q51-39 114-61.5T480-360q69 0 132 22.5T726-276q35-41 54.5-93T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 59 19.5 111t54.5 93Zm246-164q-59 0-99.5-40.5T340-580q0-59 40.5-99.5T480-720q59 0 99.5 40.5T620-580q0 59-40.5 99.5T480-440Zm0 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Z"/>
                            </svg>
                        </div>
                    @endif

                    {{-- Loading indicator --}}
                    <div wire:loading wire:target="avatar" class="absolute inset-0 bg-black bg-opacity-50 rounded-full flex items-center justify-center">
                        <svg class="animate-spin h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="flex-1">
                <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100">Profile Picture</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 mb-3">
                    Upload a photo to personalize your account (max 2MB)
                </p>

                <label for="avatar-upload" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 font-medium cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor">
                        <path d="M480-260q75 0 127.5-52.5T660-440q0-75-52.5-127.5T480-620q-75 0-127.5 52.5T300-440q0 75 52.5 127.5T480-260Zm0-80q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM160-120q-33 0-56.5-23.5T80-200v-480q0-33 23.5-56.5T160-760h126l74-80h240l74 80h126q33 0 56.5 23.5T880-680v480q0 33-23.5 56.5T800-120H160Z"/>
                    </svg>
                    <span wire:loading.remove wire:target="avatar">Change Photo</span>
                    <span wire:loading wire:target="avatar">Uploading...</span>
                </label>
                <input
                    id="avatar-upload"
                    type="file"
                    wire:model="avatar"
                    accept="image/png,image/jpeg,image/jpg,image/gif"
                    class="hidden">

                @if($avatar)
                    <p class="text-xs text-green-600 dark:text-green-400 mt-2 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        New photo selected. Click "Save Changes" to upload.
                    </p>
                @endif

                <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
            </div>
        </div>

        <!-- Full Name -->
        <div>
            <x-input-label for="name" :value="('Full Name')" />
            <x-text-input
                wire:model="name"
                id="name"
                class="block mt-1 w-full"
                required
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="('Email')" />
            <x-text-input
                wire:model="email"
                id="email"
                type="email"
                class="block mt-1 w-full"
                required
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />

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
            <x-primary-button wire:loading.attr="disabled" wire:target="avatar, updateProfileInformation">
                <span wire:loading.remove wire:target="updateProfileInformation">Save Changes</span>
                <span wire:loading wire:target="updateProfileInformation">Saving...</span>
            </x-primary-button>

            @if (session('message'))
                <div class="text-sm text-green-600 dark:text-green-400 font-medium">
                    {{ session('message') }}
                </div>
            @endif
        </div>
    </form>

    {{-- Confirmation Modal --}}
    <x-confirm-modal
        name="confirm-avatar-removal"
        title="Remove Profile Picture?"
        message="Are you sure you want to remove your profile picture? This action cannot be undone."
        confirm-text="Yes, Remove"
        cancel-text="Cancel"
        confirm-color="red"
        @confirmed="$wire.removeAvatar()"
    />
</section>
