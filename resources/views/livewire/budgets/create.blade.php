<div>
    <x-modal name="add-budget">
        <form wire:submit="save" class="p-6">
            {{-- Modal Header --}}
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Add Budget</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Set a spending limit for a category</p>
                </div>
                <button type="button"
                        x-on:click="$dispatch('close-modal', 'add-budget')"
                        class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="space-y-5">
                {{-- Category Field --}}
                <div>
                    <x-input-label for="category_id" :value="('Category')" />
                    <select wire:model="category_id"
                            id="category_id"
                            class="w-full mt-1 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:border-purple-600 dark:focus:border-purple-500 focus:ring-purple-600 dark:focus:ring-purple-500 rounded-md shadow-sm"
                            required>
                        <option value="">Select category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                </div>

                {{-- Budget Amount Field --}}
                <div>
                    <x-input-label for="amount" :value="('Budget Amount (₦)')" />
                    <x-text-input
                        type="number"
                        wire:model="amount"
                        id="amount"
                        step="0.01"
                        placeholder="0.00"
                        class="block mt-1 w-full"
                        required
                    />
                    <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                </div>

                {{-- Month Field --}}
                <div>
                    <x-input-label for="month" :value="('Month')" />
                    <select wire:model="month"
                            id="month"
                            class="w-full mt-1 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:border-purple-600 dark:focus:border-purple-500 focus:ring-purple-600 dark:focus:ring-purple-500 rounded-md shadow-sm"
                            required>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                    <x-input-error :messages="$errors->get('month')" class="mt-2" />
                </div>

                {{-- Year Field --}}
                <div>
                    <x-input-label for="year" :value="('Year')" />
                    <x-text-input
                        type="number"
                        wire:model="year"
                        id="year"
                        min="2020"
                        max="2100"
                        class="block mt-1 w-full"
                        required
                    />
                    <x-input-error :messages="$errors->get('year')" class="mt-2" />
                </div>
            </div>

            {{-- Modal Footer --}}
            <div class="flex items-center justify-end gap-3 mt-8">
                <x-secondary-button
                    type="button"
                    x-on:click="$dispatch('close-modal', 'add-budget')"
                >
                    Cancel
                </x-secondary-button>
                <x-primary-button
                    type="submit"
                >
                    Save
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</div>
