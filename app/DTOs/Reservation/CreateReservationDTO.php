<?php

namespace App\DTOs\Reservation;

readonly class CreateReservationDTO
{
    public function __construct(
        public int $orderId,
        public int $orderItemId,
        public string $idempotencyKey,
        public ?int $quantityOverride = null,
    ) {}

    public static function fromRequest(array $validated): self
    {
        return new self(
            orderId: $validated['order_id'],
            orderItemId: $validated['order_item_id'],
            idempotencyKey: $validated['idempotency_key'],
            quantityOverride: $validated['quantity'] ?? null,
        );
    }
}
