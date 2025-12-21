<div class="relative shrink-0"
     x-data="{
         showDropdown: @entangle('showDropdown'),
         init() {
             this.$watch('showDropdown', (value) => {
                 if (window.innerWidth < 1024) {
                     if (value) {
                         document.body.style.overflow = 'hidden';
                     } else {
                         document.body.style.overflow = '';
                     }
                 }
             });
         }
     }">
    {{-- Bell Icon with Badge --}}
    <button @click="showDropdown = !showDropdown"
        class="relative p-2 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>

        @if($unreadCount > 0)
            <span class="absolute top-0 right-0 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center">
                {{ $unreadCount > 5 ? '5+' : $unreadCount }}
            </span>
        @endif
    </button>

    {{-- Mobile Backdrop --}}
    <div x-show="showDropdown"
         x-cloak
         class="lg:hidden fixed inset-0 bg-black/70 z-40"
         @click="showDropdown = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
    </div>

    {{-- Dropdown Panel --}}
    <div x-show="showDropdown"
         x-cloak
         class="fixed lg:absolute inset-x-0 bottom-0 lg:inset-auto lg:right-0 lg:top-auto lg:mt-2 lg:w-96 bg-white dark:bg-gray-800 rounded-t-3xl lg:rounded-lg shadow-xl border-t lg:border border-gray-200 dark:border-gray-700 overflow-hidden z-50 max-h-[90vh] lg:max-h-[600px] flex flex-col"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="transform lg:opacity-0 lg:scale-95 translate-y-full lg:translate-y-0"
         x-transition:enter-end="transform lg:opacity-100 lg:scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="transform lg:opacity-100 lg:scale-100 translate-y-0"
         x-transition:leave-end="transform lg:opacity-0 lg:scale-95 translate-y-full lg:translate-y-0"
         @click.outside="if (window.innerWidth >= 1024) showDropdown = false"
         @touchmove.stop
         @wheel.stop>

        {{-- Mobile Handle --}}
        <div class="lg:hidden flex justify-center pt-2 pb-3">
            <div class="w-12 h-1 bg-gray-300 dark:bg-gray-600 rounded-full"></div>
        </div>

        {{-- Header --}}
        <div class="px-4 lg:px-4 py-3 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between flex-shrink-0">
            <h3 class="text-base lg:text-sm font-semibold text-gray-900 dark:text-gray-100">Notifications</h3>
            @if($unreadCount > 0)
                <button wire:click="markAllAsRead"
                        class="text-sm lg:text-xs text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 font-medium">
                    Mark all read
                </button>
            @endif
        </div>

        {{-- Notifications List --}}
        <div class="flex-1 overflow-y-auto">
            @if($notifications->count() > 0)
                @foreach($notifications as $notification)
                    <div wire:click="markAsRead({{ $notification->id }})"
                         class="px-4 lg:px-4 py-4 lg:py-3 border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer transition
                         {{ !$notification->is_read ? 'bg-blue-50 dark:bg-blue-900/10' : '' }}">

                        <div class="flex items-start gap-3">
                            {{-- Icon --}}
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 lg:w-10 lg:h-10 rounded-full flex items-center justify-center
                                    @if($notification->type === 'danger') bg-red-100 dark:bg-red-900/30
                                    @elseif($notification->type === 'warning') bg-yellow-100 dark:bg-yellow-900/30
                                    @elseif($notification->type === 'success') bg-green-100 dark:bg-green-900/30
                                    @else bg-blue-100 dark:bg-blue-900/30
                                    @endif">
                                    @if($notification->type === 'danger')
                                        <svg class="w-5 h-5 lg:w-6 lg:h-6 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                    @elseif($notification->type === 'warning')
                                        <svg class="w-5 h-5 lg:w-6 lg:h-6 text-yellow-600 dark:text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    @elseif($notification->type === 'success')
                                        <svg class="w-5 h-5 lg:w-6 lg:h-6 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 lg:w-6 lg:h-6 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-2">
                                    <h4 class="text-sm lg:text-sm font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-1.5">
                                        {{ $notification->title }}
                                        @if(!$notification->is_read)
                                            <span class="w-2 h-2 lg:w-1.5 lg:h-1.5 bg-blue-600 dark:bg-blue-500 rounded-full"></span>
                                        @endif
                                    </h4>
                                </div>
                                <p class="text-sm lg:text-xs text-gray-600 dark:text-gray-400 mt-1 line-clamp-2">
                                    {{ $notification->message }}
                                </p>
                                <span class="text-xs lg:text-xs text-gray-500 dark:text-gray-500 mt-1.5 lg:mt-1 inline-block">
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="px-4 py-16 lg:py-12 text-center text-gray-500 dark:text-gray-400">
                    <svg class="w-16 h-16 lg:w-12 lg:h-12 mx-auto mb-3 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <p class="text-base lg:text-sm font-medium">No notifications</p>
                    <p class="text-sm lg:text-xs mt-1">You're all caught up!</p>
                </div>
            @endif
        </div>

        {{-- Footer --}}
        @if($notifications->count() > 0)
            <div class="px-4 lg:px-4 py-4 lg:py-3 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 flex-shrink-0">
                <a href="{{ route('notifications.index') }}"
                   wire:navigate
                   @click="showDropdown = false"
                   class="block text-center text-base lg:text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 font-medium">
                    View all notifications
                </a>
            </div>
        @endif
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</div>
