<?php

namespace App\Models;

use App\Enums\ReservationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'idempotency_key',
        'order_id',
        'order_item_id',
        'product_id',
        'warehouse_id',
        'quantity',
        'status',
        'expires_at',
        'released_at',
        'consumed_at',
        'released_reason',
    ];

    protected $casts = [
        'status'      => ReservationStatus::class,
        'quantity'     => 'integer',
        'expires_at'  => 'datetime',
        'released_at' => 'datetime',
        'consumed_at' => 'datetime',
    ];

    // ── Relationships ──

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    // ── Scopes ──

    public function scopeActive($query)
    {
        return $query->where('status', ReservationStatus::ACTIVE);
    }

    public function scopeExpired($query)
    {
        return $query->where('status', ReservationStatus::ACTIVE)
            ->where('expires_at', '<=', now());
    }

    public function scopeForProduct($query, int $productId, int $warehouseId)
    {
        return $query->where('product_id', $productId)
            ->where('warehouse_id', $warehouseId);
    }
}
