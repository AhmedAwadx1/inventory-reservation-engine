<?php

namespace App\DTOs\Inventory;

use App\Enums\InventoryBucket;
use App\Enums\MovementType;

readonly class MoveBucketDTO
{
    public function __construct(
        public int $productId,
        public int $warehouseId,
        public InventoryBucket $fromBucket,
        public InventoryBucket $toBucket,
        public int $quantity,
        public MovementType $type,
        public string $idempotencyKey,
        public ?int $reservationId = null,
        public ?int $shipmentId = null,
        public ?int $orderId = null,
        public ?string $reason = null,
        public ?array $metadata = null,
    ) {}
}
