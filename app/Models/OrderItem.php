<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'warehouse_id',
        'quantity_ordered',
        'quantity_reserved',
        'quantity_shipped',
        'quantity_delivered',
        'status',
    ];

    protected $casts = [
        'quantity_ordered'   => 'integer',
        'quantity_reserved'  => 'integer',
        'quantity_shipped'   => 'integer',
        'quantity_delivered' => 'integer',
        'status'             => OrderStatus::class,
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function shipmentItems(): HasMany
    {
        return $this->hasMany(ShipmentItem::class);
    }

    /**
     * Check if this item is fully reserved.
     */
    public function getIsFullyReservedAttribute(): bool
    {
        return $this->quantity_reserved >= $this->quantity_ordered;
    }

    /**
     * Check if this item is fully shipped.
     */
    public function getIsFullyShippedAttribute(): bool
    {
        return $this->quantity_shipped >= $this->quantity_ordered;
    }
}
