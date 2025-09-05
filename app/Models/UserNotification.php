<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'notification_id',
        'is_read',
        'read_at',
        'is_sent_email',
        'email_sent_at',
        'is_sent_sms',
        'sms_sent_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'is_sent_email' => 'boolean',
        'email_sent_at' => 'datetime',
        'is_sent_sms' => 'boolean',
        'sms_sent_at' => 'datetime',
    ];

    /**
     * Get the user that owns the notification
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the notification
     */
    public function notification(): BelongsTo
    {
        return $this->belongsTo(Notification::class);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(): bool
    {
        return $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    /**
     * Mark notification as unread
     */
    public function markAsUnread(): bool
    {
        return $this->update([
            'is_read' => false,
            'read_at' => null,
        ]);
    }

    /**
     * Mark email as sent
     */
    public function markEmailAsSent(): bool
    {
        return $this->update([
            'is_sent_email' => true,
            'email_sent_at' => now(),
        ]);
    }

    /**
     * Mark SMS as sent
     */
    public function markSmsAsSent(): bool
    {
        return $this->update([
            'is_sent_sms' => true,
            'sms_sent_at' => now(),
        ]);
    }
}
