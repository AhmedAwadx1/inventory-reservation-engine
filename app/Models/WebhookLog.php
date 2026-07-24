<?php

namespace App\Models;

use App\Enums\WebhookStatus;
use Illuminate\Database\Eloquent\Model;

class WebhookLog extends Model
{
    protected $fillable = [
        'provider',
        'event_id',
        'event_type',
        'payload',
        'status',
        'error_message',
        'processed_at',
    ];

    protected $casts = [
        'status'       => WebhookStatus::class,
        'payload'      => 'array',
        'processed_at' => 'datetime',
    ];

    // ── Scopes ──

    public function scopeProcessed($query)
    {
        return $query->where('status', WebhookStatus::PROCESSED);
    }

    public function scopeForEvent($query, string $eventId)
    {
        return $query->where('event_id', $eventId);
    }
}
