<?php

namespace App\Enums;

use App\Enums\Concerns\HasTranslatableLabel;

enum InventoryBucket: int
{
    use HasTranslatableLabel;

    case AVAILABLE = 1;
    case RESERVED  = 2;
    case PICKED    = 3;
    case PACKED    = 4;
    case SHIPPED   = 5;
    case DELIVERED = 6;
    case EXTERNAL  = 0;

    /**
     * Get the corresponding column name in the inventory table.
     *
     * @throws \LogicException If called on EXTERNAL bucket
     */
    public function columnName(): string
    {
        return match ($this) {
            self::AVAILABLE => 'quantity_available',
            self::RESERVED  => 'quantity_reserved',
            self::PICKED    => 'quantity_picked',
            self::PACKED    => 'quantity_packed',
            self::SHIPPED   => 'quantity_shipped',
            self::DELIVERED => 'quantity_delivered',
            self::EXTERNAL  => throw new \LogicException('External bucket has no column'),
        };
    }
}
