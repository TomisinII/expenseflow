<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex flex-col gap-2">
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200">
                    Profile
                </h2>
                <p class="text-sm font-semibold text-gray-400">Manage your account settings and preferences</p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Personal Information Card -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-6">
                    Personal Information
                </h3>
                <livewire:profile.update-profile-information-form />
            </div>
        </div>

        <!-- Preferences Card -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-6">
                    Preferences
                </h3>
                <livewire:profile.update-preferences-form />
            </div>
        </div>

        <!-- Update Password Card -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-6">
                    Update Password
                </h3>
                <livewire:profile.update-password-form />
            </div>
        </div>

        <!-- Danger Zone Card -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-2 border-red-200 dark:border-red-800">
            <div class="p-6">
                <h3 class="text-xl font-bold text-red-600 dark:text-red-400 mb-6">
                    Danger Zone
                </h3>

                <!-- Export Data Section -->
                <div class="mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100">Export Data</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Download all your expense data as CSV
                            </p>
                        </div>
                        <button
                            type="button"
                            class="px-6 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                            Export
                        </button>
                    </div>
                </div>

                <!-- Delete Account Section -->
                <livewire:profile.delete-user-form />
            </div>
        </div>
    </div>
</x-app-layout>
