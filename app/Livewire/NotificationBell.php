<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use App\Services\NotificationService;

class NotificationBell extends Component
{
    public $unreadCount = 0;
    public $showDropdown = false;

    protected NotificationService $notificationService;

    public function boot(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function mount()
    {
        $this->loadUnreadCount();
    }

    #[On('notification-created')]
    #[On('notification-updated')]
    public function loadUnreadCount()
    {
        $this->unreadCount = Auth::user()
            ->notifications()
            ->unread()
            ->count();
    }

    public function toggleDropdown()
    {
        $this->showDropdown = !$this->showDropdown;
    }

    public function markAsRead($notificationId)
    {
        $notification = Auth::user()->notifications()->find($notificationId);

        if (!$notification) {
            return;
        }

        $this->notificationService->markAsRead($notification);
        $this->dispatch('notification-updated');
    }

    public function markAllAsRead()
    {
        $this->notificationService->markAllAsRead(Auth::user());
        $this->dispatch('notification-updated');
        $this->dispatch('message', 'All notifications marked as read');
        $this->showDropdown = false;
    }

    public function render()
    {
        $notifications = Auth::user()
            ->notifications()
            ->latest()
            ->limit(5)
            ->get();

        return view('livewire.notification-bell', [
            'notifications' => $notifications,
        ]);
    }
}
