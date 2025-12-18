<div>
    <x-modal name="add-category">
        <form wire:submit="save" class="p-6">
            {{-- Modal Header --}}
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Add Category</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Create a new category for your expenses</p>
                </div>
                <button type="button"
                        x-on:click="$dispatch('close-modal', 'add-category')"
                        class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

           <div class="space-y-5">
                {{-- Category Name --}}
                <div>
                    <x-input-label for="name" :value="__('Category Name')" />
                    <x-text-input
                        type="text"
                        wire:model.live="name"
                        id="name"
                        placeholder="e.g., Entertainment"
                        class="block mt-1 w-full"
                        required
                    />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                {{-- Select Icon --}}
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-gray-100 mb-3">Select Icon</label>
                    <div class="grid grid-cols-5 gap-3 max-h-64 overflow-y-auto pr-2">
                        @foreach($availableIcons as $iconOption)
                            <button
                                type="button"
                                wire:click="$set('icon', '{{ $iconOption }}')"
                                class="w-full aspect-square rounded-lg border-2 transition-all flex items-center justify-center text-3xl hover:border-indigo-300 dark:hover:border-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/30
                                    {{ $icon === $iconOption ? 'border-indigo-600 dark:border-indigo-500 bg-indigo-50 dark:bg-indigo-900/30' : 'border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700' }}">
                                {{ $iconOption }}
                            </button>
                        @endforeach
                    </div>
                    <x-input-error :messages="$errors->get('icon')" class="mt-2" />
                </div>

                {{-- Select Color --}}
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-gray-100 mb-3">Select Color</label>
                    <div class="grid grid-cols-6 gap-3">
                        @foreach($availableColors as $colorOption)
                            <button
                                type="button"
                                wire:click="$set('color', '{{ $colorOption }}')"
                                class="w-full aspect-square rounded-lg border-2 transition-all
                                    {{ $color === $colorOption ? 'border-gray-800 dark:border-gray-200 ring-2 ring-gray-800 dark:ring-gray-200 ring-offset-2 dark:ring-offset-gray-900' : 'border-gray-200 dark:border-gray-600' }}"
                                style="background-color: {{ $colorOption }};">
                            </button>
                        @endforeach
                    </div>
                    <x-input-error :messages="$errors->get('color')" class="mt-2" />
                </div>

                {{-- Preview --}}
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-gray-100 mb-3">Preview</label>
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 flex items-center gap-4">
                        <div class="w-16 h-16 rounded-full flex items-center justify-center text-3xl"
                             style="background-color: {{ $color }}20;">
                            {{ $icon }}
                        </div>
                        <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            {{ $name ?: 'Category Name' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Modal Footer --}}
            <div class="flex items-center justify-end gap-3 mt-8">
                <x-secondary-button type="button" x-on:click="$dispatch('close-modal', 'add-category')">
                    Cancel
                </x-secondary-button>

                <x-primary-button type="submit">
                    Save
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</div>
