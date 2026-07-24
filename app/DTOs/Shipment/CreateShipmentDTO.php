<?php

namespace App\DTOs\Shipment;

readonly class CreateShipmentDTO
{
    /**
     * @param  array<int, array{order_item_id: int, quantity: int}>  $items
     */
    public function __construct(
        public int $orderId,
        public int $warehouseId,
        public array $items,
        public string $idempotencyKey,
    ) {}

    public static function fromRequest(array $validated): self
    {
        return new self(
            orderId: $validated['order_id'],
            warehouseId: $validated['warehouse_id'],
            items: $validated['items'],
            idempotencyKey: $validated['idempotency_key'],
        );
    }
}
