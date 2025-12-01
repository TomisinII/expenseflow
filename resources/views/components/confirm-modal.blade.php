{{-- resources/views/components/confirm-modal.blade.php --}}

@props([
    'name',
    'title' => 'Confirm Action',
    'message' => 'Are you sure you want to proceed?',
    'confirmText' => 'Confirm',
    'cancelText' => 'Cancel',
    'confirmColor' => 'red', // red, blue, green, etc.
])

<div
    x-data="{ show: false }"
    x-on:open-modal.window="if ($event.detail === '{{ $name }}') show = true"
    x-on:close-modal.window="if ($event.detail === '{{ $name }}') show = false"
    x-show="show"
    x-cloak
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none;"
>
    {{-- Backdrop --}}
    <div
        x-show="show"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity"
        @click="show = false"
    ></div>

    {{-- Modal Container --}}
    <div class="flex min-h-screen items-center justify-center p-4">
        {{-- Modal Content --}}
        <div
            x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative bg-white rounded-lg shadow-xl max-w-md w-full"
            @click.away="show = false"
        >
            <div class="p-6">
                {{-- Icon --}}
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full mb-4
                    @if($confirmColor === 'red') bg-red-100
                    @elseif($confirmColor === 'blue') bg-blue-100
                    @elseif($confirmColor === 'green') bg-green-100
                    @elseif($confirmColor === 'yellow') bg-yellow-100
                    @else bg-gray-100
                    @endif">
                    @if($confirmColor === 'red')
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    @elseif($confirmColor === 'blue')
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    @elseif($confirmColor === 'green')
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    @else
                        <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    @endif
                </div>

                {{-- Title --}}
                <h3 class="text-lg font-semibold text-gray-900 text-center mb-2">
                    {{ $title }}
                </h3>

                {{-- Message --}}
                <p class="text-sm text-gray-600 text-center mb-6">
                    {{ $message }}
                </p>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-3">
                    <button type="button"
                            @click="show = false; $dispatch('close-modal', '{{ $name }}')"
                            class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-lg transition">
                        {{ $cancelText }}
                    </button>

                    <button type="button"
                            @click="show = false; $dispatch('confirmed', '{{ $name }}'); $dispatch('close-modal', '{{ $name }}')"
                            class="px-4 py-2 text-sm font-medium text-white rounded-lg transition
                                @if($confirmColor === 'red') bg-red-600 hover:bg-red-700
                                @elseif($confirmColor === 'blue') bg-blue-600 hover:bg-blue-700
                                @elseif($confirmColor === 'green') bg-green-600 hover:bg-green-700
                                @elseif($confirmColor === 'yellow') bg-yellow-600 hover:bg-yellow-700
                                @else bg-gray-600 hover:bg-gray-700
                                @endif">
                        {{ $confirmText }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>
