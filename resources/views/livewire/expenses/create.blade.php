<div>
    <x-modal name="add-expense">
        <form wire:submit="save" class="p-6">
            {{-- Modal Header --}}
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Add Expense</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Add a new expense to track your spending</p>
                </div>
                <button type="button"
                        x-on:click="$dispatch('close-modal', 'add-expense')"
                        class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="space-y-5">
                {{-- Amount Field --}}
                <div>
                    <x-input-label for="amount" :value="('Amount (₦)')" />
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

                {{-- Date Field --}}
                <div>
                    <x-input-label for="expense_date" :value="('Date')" />

                    <x-text-input
                        type="date"
                        wire:model="expense_date"
                        id="expense_date"
                        class="block mt-1 w-full"
                        required
                    />

                    <x-input-error :messages="$errors->get('expense_date')" class="mt-2" />
                </div>

                {{-- Description Field --}}
                <div>
                    <x-input-label for="description" :value="('Description')" />

                    <x-text-input
                        type="text"
                        wire:model="description"
                        id="description"
                        placeholder="e.g., Lunch at restaurant"
                        class="block mt-1 w-full"
                        required
                    />

                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                {{-- Payment Method Field --}}
                <div>
                    <x-input-label for="payment_method" :value="('Payment Method')" />

                    <select wire:model="payment_method"
                            id="payment_method"
                            class="w-full mt-1 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:border-purple-600 dark:focus:border-purple-500 focus:ring-purple-600 dark:focus:ring-purple-500 rounded-md shadow-sm"
                            required>
                        <option value="">Select payment method</option>
                        <option value="cash">Cash</option>
                        <option value="card">Card</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="other">Other</option>
                    </select>
                    <x-input-error :messages="$errors->get('payment_method')" class="mt-2" />
                </div>

                {{-- Notes Field (Optional) --}}
                <div>
                    <x-input-label for="notes" :value="('Notes (Optional)')" />

                    <textarea
                        wire:model="notes"
                        id="notes"
                        rows="3"
                        placeholder="Add any additional notes..."
                        class="w-full mt-1 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:placeholder-gray-400 focus:border-purple-600 dark:focus:border-purple-500 focus:ring-purple-600 dark:focus:ring-purple-500 rounded-md shadow-sm resize-none"></textarea>

                    <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                </div>
            </div>

            {{-- Modal Footer --}}
            <div class="flex items-center justify-end gap-3 mt-8">
                <x-secondary-button type="button"
                    x-on:click="$dispatch('close-modal', 'add-expense')">
                    Cancel
                </x-secondary-button>
                <x-primary-button type="submit">
                    Save
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</div>
