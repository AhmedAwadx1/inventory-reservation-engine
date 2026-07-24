<?php

namespace App\DTOs\Inventory;

readonly class AddStockDTO
{
    public function __construct(
        public int $productId,
        public int $warehouseId,
        public int $quantity,
        public string $idempotencyKey,
        public ?string $reason = null,
    ) {}

    public static function fromRequest(array $validated): self
    {
        return new self(
            productId: $validated['product_id'],
            warehouseId: $validated['warehouse_id'],
            quantity: $validated['quantity'],
            idempotencyKey: $validated['idempotency_key'],
            reason: $validated['reason'] ?? null,
        );
    }
}
