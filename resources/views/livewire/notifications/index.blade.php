<div>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex flex-col gap-1">
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100">
                    Notifications
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    You have {{ $unreadCount }} unread notification{{ $unreadCount !== 1 ? 's' : '' }}
                </p>
            </div>

            <div class="flex items-center gap-3">
                {{-- Filter Dropdown (Type Filter) --}}
                <div x-data="{
                    open: false,
                    setFilter(type) {
                        @this.setTypeFilter(type);
                        this.open = false;
                    }
                }" @click.outside="open = false" class="relative">
                    <button
                        @click="open = !open"
                        type="button"
                        class="flex items-center gap-2 px-4 py-2 text-sm border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition
                        {{ $typeFilter ? 'bg-indigo-50 dark:bg-indigo-900/20 border-indigo-300 dark:border-indigo-700' : '' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        <span>
                            @if($typeFilter)
                                {{ ucfirst($typeFilter) }}
                            @else
                                Filter by Type
                            @endif
                        </span>
                        @if($typeFilter)
                            <span class="w-1.5 h-1.5 rounded-full
                                @if($typeFilter === 'success') bg-green-500
                                @elseif($typeFilter === 'warning') bg-yellow-500
                                @elseif($typeFilter === 'danger') bg-red-500
                                @elseif($typeFilter === 'info') bg-blue-500
                                @endif"></span>
                        @endif
                    </button>

                    {{-- Dropdown Menu --}}
                    <div x-show="open"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 py-1 z-10"
                        style="display: none;">
                        <button
                            type="button"
                            @click="setFilter('')"
                            class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ $typeFilter === '' ? 'bg-gray-50 dark:bg-gray-700/50 font-medium' : '' }}">
                            All Notifications
                        </button>
                        <button
                            type="button"
                            @click="setFilter('success')"
                            class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center gap-2 {{ $typeFilter === 'success' ? 'bg-gray-50 dark:bg-gray-700/50 font-medium' : '' }}">
                            <span class="w-2 h-2 rounded-full bg-green-500"></span>
                            Success
                        </button>
                        <button
                            type="button"
                            @click="setFilter('warning')"
                            class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center gap-2 {{ $typeFilter === 'warning' ? 'bg-gray-50 dark:bg-gray-700/50 font-medium' : '' }}">
                            <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                            Warning
                        </button>
                        <button
                            type="button"
                            @click="setFilter('danger')"
                            class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center gap-2 {{ $typeFilter === 'danger' ? 'bg-gray-50 dark:bg-gray-700/50 font-medium' : '' }}">
                            <span class="w-2 h-2 rounded-full bg-red-500"></span>
                            Danger
                        </button>
                        <button
                            type="button"
                            @click="setFilter('info')"
                            class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center gap-2 {{ $typeFilter === 'info' ? 'bg-gray-50 dark:bg-gray-700/50 font-medium' : '' }}">
                            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                            Info
                        </button>
                    </div>
                </div>

                {{-- Mark All Read --}}
                @if($unreadCount > 0)
                    <button
                        x-on:click="$dispatch('open-modal', 'mark-all-read')"
                        class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Mark all read
                    </button>
                @endif

                {{-- Clear All --}}
                @if($notifications->count() > 0)
                    <button
                        x-on:click="$dispatch('open-modal', 'clear-all')"
                        class="flex items-center gap-2 px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Clear all
                    </button>
                @endif
            </div>
        </div>
    </x-slot>

    {{-- Success Message --}}
    <x-action-message on="message" class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-300 px-4 py-3 rounded-lg flex items-center justify-between min-w-80">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <span x-text="message"></span>
        </div>
    </x-action-message>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        {{-- Active Filter Badge --}}
        @if($typeFilter)
            <div class="mb-4 flex items-center gap-2">
                <span class="text-sm text-gray-600 dark:text-gray-400">Filtered by:</span>
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium
                    @if($typeFilter === 'success') bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300
                    @elseif($typeFilter === 'warning') bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300
                    @elseif($typeFilter === 'danger') bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300
                    @elseif($typeFilter === 'info') bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300
                    @endif">
                    <span class="w-1.5 h-1.5 rounded-full
                        @if($typeFilter === 'success') bg-green-500
                        @elseif($typeFilter === 'warning') bg-yellow-500
                        @elseif($typeFilter === 'danger') bg-red-500
                        @elseif($typeFilter === 'info') bg-blue-500
                        @endif"></span>
                    {{ ucfirst($typeFilter) }}
                    <button wire:click="setTypeFilter('')" class="ml-1 hover:bg-white/20 rounded-full p-0.5">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </span>
            </div>
        @endif

        {{-- Filter Tabs (Read Status Filter) --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 mb-6 p-1">
            <div class="flex items-center gap-1">
                <button wire:click="setStatusFilter('all')"
                        class="px-6 py-2.5 text-sm font-medium rounded-lg transition
                            {{ $statusFilter === 'all' ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
                    All ({{ $allCount }})
                </button>
                <button wire:click="setStatusFilter('unread')"
                        class="px-6 py-2.5 text-sm font-medium rounded-lg transition
                            {{ $statusFilter === 'unread' ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
                    Unread ({{ $unreadCount }})
                </button>
                <button wire:click="setStatusFilter('read')"
                        class="px-6 py-2.5 text-sm font-medium rounded-lg transition
                            {{ $statusFilter === 'read' ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
                    Read ({{ $readCount }})
                </button>
            </div>
        </div>

        {{-- Notifications List --}}
        <div x-data="{ notificationToDelete: null }"
             @confirmed.window="
                if ($event.detail === 'delete-notification' && notificationToDelete) {
                    $wire.delete(notificationToDelete);
                    notificationToDelete = null;
                }
                if ($event.detail === 'mark-all-read') {
                    $wire.markAllAsRead();
                }
                if ($event.detail === 'clear-all') {
                    $wire.clearAll();
                }
             ">
            @if($notifications->count() > 0)
                <div class="space-y-3">
                    @foreach($notifications as $notification)
                        <div class="bg-white dark:bg-gray-800 rounded-xl border-l-4
                            @if($notification->type === 'danger') border-red-500
                            @elseif($notification->type === 'warning') border-yellow-500
                            @elseif($notification->type === 'success') border-green-500
                            @else border-blue-500
                            @endif
                            border-r border-t border-b border-gray-200 dark:border-gray-700
                            hover:shadow-md transition-shadow">

                            <div class="p-5 flex items-start gap-4">
                                {{-- Icon --}}
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center
                                        @if($notification->type === 'danger') bg-red-100 dark:bg-red-900/30
                                        @elseif($notification->type === 'warning') bg-yellow-100 dark:bg-yellow-900/30
                                        @elseif($notification->type === 'success') bg-green-100 dark:bg-green-900/30
                                        @else bg-blue-100 dark:bg-blue-900/30
                                        @endif">
                                        @if($notification->type === 'danger')
                                            <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                            </svg>
                                        @elseif($notification->type === 'warning')
                                            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        @elseif($notification->type === 'success')
                                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                        @else
                                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                    </div>
                                </div>

                                {{-- Content --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-4 mb-2">
                                        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                            {{ $notification->title }}
                                            @if(!$notification->is_read)
                                                <span class="w-2 h-2 bg-blue-600 dark:bg-blue-500 rounded-full"></span>
                                            @endif
                                        </h3>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                        {{ $notification->message }}
                                    </p>

                                    {{-- Actions --}}
                                    <div class="flex items-center gap-4">
                                        @if(!$notification->is_read)
                                            <button wire:click="markAsRead({{ $notification->id }})"
                                                    class="flex items-center gap-1.5 text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Mark as read
                                            </button>
                                        @endif
                                        <button
                                            @click="notificationToDelete = {{ $notification->id }}; $dispatch('open-modal', 'delete-notification')"
                                            class="flex items-center gap-1.5 text-sm text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-6">
                    {{ $notifications->links() }}
                </div>
            @else
                {{-- Empty State --}}
                <div class="text-center py-12 text-gray-400 dark:text-gray-500">
                    <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        @if($statusFilter === 'unread')
                            No unread notifications
                        @elseif($statusFilter === 'read')
                            No read notifications
                        @else
                            No notifications yet
                        @endif
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        @if($statusFilter === 'all')
                            You'll see notifications here when there's activity on your account
                        @else
                            Try switching to a different filter
                        @endif
                    </p>
                </div>
            @endif

            {{-- Confirmation Modals --}}
            <x-confirm-modal
                name="delete-notification"
                title="Delete Notification"
                message="Are you sure you want to delete this notification? This action cannot be undone."
                confirmText="Delete"
                cancelText="Cancel"
                confirmColor="red"
            />
        </div>
    </div>

    {{-- Mark All Read Confirmation Modal --}}
    <x-confirm-modal
        name="mark-all-read"
        title="Mark All as Read"
        message="Are you sure you want to mark all {{ $unreadCount }} notification{{ $unreadCount !== 1 ? 's' : '' }} as read?"
        confirmText="Mark All Read"
        cancelText="Cancel"
        confirmColor="blue"
    />

    {{-- Clear All Confirmation Modal --}}
    <x-confirm-modal
        name="clear-all"
        title="Clear All Notifications"
        message="Are you sure you want to delete all {{ $allCount }} notification{{ $allCount !== 1 ? 's' : '' }}? This action cannot be undone."
        confirmText="Clear All"
        cancelText="Cancel"
        confirmColor="red"
    />
</div>
