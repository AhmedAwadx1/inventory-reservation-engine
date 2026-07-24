<?php

namespace App\Models;

use App\Enums\InventoryBucket;
use App\Enums\MovementType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryMovement extends Model
{
    public $timestamps = false; // Only has created_at

    protected $fillable = [
        'uuid',
        'idempotency_key',
        'product_id',
        'warehouse_id',
        'reservation_id',
        'shipment_id',
        'order_id',
        'type',
        'from_bucket',
        'to_bucket',
        'quantity',
        'reason',
        'metadata',
        'created_at',
    ];

    protected $casts = [
        'type'        => MovementType::class,
        'from_bucket' => InventoryBucket::class,
        'to_bucket'   => InventoryBucket::class,
        'quantity'    => 'integer',
        'metadata'    => 'array',
        'created_at'  => 'datetime',
    ];

    // ── Relationships ──

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }

    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    // ── Boot ──

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $model) {
            $model->created_at = $model->created_at ?? now();
        });
    }
}
