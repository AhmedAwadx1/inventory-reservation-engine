<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventory';

    protected $fillable = [
        'product_id',
        'warehouse_id',
        'quantity_available',
        'quantity_reserved',
        'quantity_picked',
        'quantity_packed',
        'quantity_shipped',
        'quantity_delivered',
        'version',
    ];

    protected $casts = [
        'quantity_available' => 'integer',
        'quantity_reserved'  => 'integer',
        'quantity_picked'    => 'integer',
        'quantity_packed'    => 'integer',
        'quantity_shipped'   => 'integer',
        'quantity_delivered' => 'integer',
        'version'            => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function movements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class, 'product_id', 'product_id')
            ->where('warehouse_id', $this->warehouse_id);
    }

    /**
     * Total quantity across all buckets.
     */
    public function getTotalQuantityAttribute(): int
    {
        return $this->quantity_available
            + $this->quantity_reserved
            + $this->quantity_picked
            + $this->quantity_packed
            + $this->quantity_shipped
            + $this->quantity_delivered;
    }
}
