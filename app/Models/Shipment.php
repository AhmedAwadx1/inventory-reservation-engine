<?php

namespace App\Models;

use App\Enums\ShipmentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'order_id',
        'warehouse_id',
        'tracking_number',
        'carrier',
        'status',
        'provider_reference',
        'attempt_count',
        'shipped_at',
        'delivered_at',
        'failure_reason',
    ];

    protected $casts = [
        'status'        => ShipmentStatus::class,
        'attempt_count' => 'integer',
        'shipped_at'    => 'datetime',
        'delivered_at'  => 'datetime',
    ];

    // ── Relationships ──

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ShipmentItem::class);
    }

    // ── Scopes ──

    public function scopePending($query)
    {
        return $query->where('status', ShipmentStatus::PENDING);
    }

    public function scopeProcessable($query)
    {
        return $query->whereIn('status', [
            ShipmentStatus::PENDING,
            ShipmentStatus::PROCESSING,
        ]);
    }
}
