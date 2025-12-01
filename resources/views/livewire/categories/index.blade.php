<div>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex flex-col gap-2">
                <h2 class="font-bold text-2xl text-gray-800">
                    Categories
                </h2>
                <p class="text-sm font-semibold text-gray-400">Organize your expenses with custom categories</p>
            </div>

            <x-primary-button x-on:click="$dispatch('open-modal', 'add-category')" class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="currentColor"><path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"/></svg>
                Add Category
            </x-primary-button>

        </div>
    </x-slot>

    {{-- Success Message --}}
    <x-action-message on="message" class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center justify-between min-w-80">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <span x-text="message"></span>
        </div>
    </x-action-message>

    <div class="space-y-6">
        {{-- Category Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            @foreach($categories as $category)
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow cursor-pointer">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4 text-3xl" style="background-color: {{ $category->color }}20;">
                            {{ $category->icon }}
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $category->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $category->expenses_count }} expenses</p>
                    </div>
                </div>
            @endforeach

            {{-- Add Category Card --}}
            <button
                x-on:click="$dispatch('open-modal', 'add-category')"
                class="bg-white rounded-xl p-6 shadow-sm border-2 border-dashed border-gray-300 hover:border-indigo-400 hover:bg-gray-50 transition-all cursor-pointer">
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Add Category</h3>
                    <p class="text-sm text-gray-500">Create a new expense category</p>
                </div>
            </button>
        </div>

        {{-- Category Statistics --}}
        @if($categories->count() > 0)
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Category Statistics</h3>

                <div class="space-y-6">
                    @foreach($categoryStats as $stat)
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center text-2xl flex-shrink-0" style="background-color: {{ $stat['color'] }}20;">
                                {{ $stat['icon'] }}
                            </div>

                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-semibold text-gray-900">{{ $stat['name'] }}</span>
                                    <div class="flex items-center gap-3">
                                        <span class="text-sm font-medium text-gray-500">{{ $stat['percentage'] }}%</span>
                                        <span class="text-sm font-bold text-gray-900">{{ $stat['count'] }}</span>
                                    </div>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div
                                        class="h-2 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500"
                                        style="width: {{ $stat['percentage'] }}%">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div x-data="{}"
            @scroll-to-top.window="window.scrollTo({ top: 0, behavior: 'smooth' })"
            style="display: none;">
        </div>

        @livewire('categories.create')
    </div>
</div>
