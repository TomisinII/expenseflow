<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'data',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the notification.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope to get unread notifications.
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope to get read notifications.
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead(): void
    {
        if (!$this->is_read) {
            $this->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }
    }

    /**
     * Get the icon class based on notification type.
     */
    public function getIconAttribute(): string
    {
        return match($this->type) {
            'success' => 'heroicon-o-check-circle',
            'warning' => 'heroicon-o-exclamation-triangle',
            'danger' => 'heroicon-o-x-circle',
            'info' => 'heroicon-o-information-circle',
            default => 'heroicon-o-bell',
        };
    }

    /**
     * Get the color class based on notification type.
     */
    public function getColorClassAttribute(): string
    {
        return match($this->type) {
            'success' => 'text-green-600 bg-green-50 dark:bg-green-900/20',
            'warning' => 'text-amber-600 bg-amber-50 dark:bg-amber-900/20',
            'danger' => 'text-red-600 bg-red-50 dark:bg-red-900/20',
            'info' => 'text-blue-600 bg-blue-50 dark:bg-blue-900/20',
            default => 'text-gray-600 bg-gray-50 dark:bg-gray-900/20',
        };
    }

    /**
     * Get human-readable time ago format.
     */
    public function getTimeAgoAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }
}
