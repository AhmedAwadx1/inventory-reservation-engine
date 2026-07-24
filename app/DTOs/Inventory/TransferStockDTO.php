<?php

namespace App\DTOs\Inventory;

readonly class TransferStockDTO
{
    public function __construct(
        public int $productId,
        public int $sourceWarehouseId,
        public int $destinationWarehouseId,
        public int $quantity,
        public string $idempotencyKey,
        public ?string $reason = null,
    ) {}

    public static function fromRequest(array $validated): self
    {
        return new self(
            productId: $validated['product_id'],
            sourceWarehouseId: $validated['source_warehouse_id'],
            destinationWarehouseId: $validated['destination_warehouse_id'],
            quantity: $validated['quantity'],
            idempotencyKey: $validated['idempotency_key'],
            reason: $validated['reason'] ?? null,
        );
    }
}
