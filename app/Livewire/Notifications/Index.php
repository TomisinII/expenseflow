<?php

namespace App\Livewire\Notifications;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Services\NotificationService;
use Livewire\Attributes\On;

class Index extends Component
{
    use WithPagination;

    public $typeFilter = ''; // '', 'success', 'warning', 'danger', 'info'
    public $statusFilter = 'all'; // 'all', 'unread', 'read'

    protected NotificationService $notificationService;

    public function boot(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function setTypeFilter($filter)
    {
        $validFilters = ['', 'success', 'warning', 'danger', 'info'];

        if (!in_array($filter, $validFilters, true)) {
            return;
        }

        $this->typeFilter = $filter;
        $this->resetPage();
    }

    public function setStatusFilter($filter)
    {
        $validFilters = ['all', 'unread', 'read'];

        if (!in_array($filter, $validFilters, true)) {
            return;
        }

        $this->statusFilter = $filter;
        $this->resetPage();
    }

    public function markAsRead($notificationId)
    {
        $notification = Auth::user()->notifications()->find($notificationId);

        if (!$notification) {
            $this->dispatch('message', 'Notification not found');
            return;
        }

        $this->notificationService->markAsRead($notification);
        $this->dispatch('message', 'Notification marked as read');
        $this->dispatch('notification-updated');
    }

    #[On('notification-updated')]
    public function refreshNotifications()
    {
        // This will trigger a re-render
    }

    public function markAllAsRead()
    {
        $count = $this->notificationService->markAllAsRead(Auth::user());

        $this->dispatch('message', sprintf('Marked %d notification%s as read', $count, $count !== 1 ? 's' : ''));
        $this->dispatch('notification-updated');
    }

    public function delete($notificationId)
    {
        $user = Auth::user();
        $notification = $user->notifications()->find($notificationId);

        if ($notification) {
            $notification->delete();
            $this->dispatch('message', 'Notification deleted successfully!');
            $this->dispatch('notification-updated');
        } else {
            $this->dispatch('message', 'Notification not found or unauthorized.');
        }
    }

    public function clearAll()
    {
        $count = Auth::user()->notifications()->count();

        Auth::user()->notifications()->delete();

        $this->dispatch('message', sprintf('Cleared %d notification%s', $count, $count !== 1 ? 's' : ''));
        $this->dispatch('notification-updated');

        $this->resetPage();
    }

    public function render()
    {
        // Start with base query
        $query = Auth::user()->notifications()->latest();

        // Apply type filter if set
        if (!empty($this->typeFilter)) {
            $query->where('type', $this->typeFilter);
        }

        // Apply status filter
        if ($this->statusFilter === 'unread') {
            $query->where('is_read', false);
        } elseif ($this->statusFilter === 'read') {
            $query->where('is_read', true);
        }

        // Get paginated notifications
        $notifications = $query->paginate(10);

        // Build base query for counts (respecting type filter)
        $countQuery = Auth::user()->notifications();

        if (!empty($this->typeFilter)) {
            $countQuery = $countQuery->where('type', $this->typeFilter);
        }

        // Get counts
        $allCount = (clone $countQuery)->count();
        $unreadCount = (clone $countQuery)->where('is_read', false)->count();
        $readCount = (clone $countQuery)->where('is_read', true)->count();

        return view('livewire.notifications.index', [
            'notifications' => $notifications,
            'allCount' => $allCount,
            'unreadCount' => $unreadCount,
            'readCount' => $readCount,
        ]);
    }
}
