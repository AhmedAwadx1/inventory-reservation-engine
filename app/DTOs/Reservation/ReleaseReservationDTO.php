<?php

namespace App\DTOs\Reservation;

readonly class ReleaseReservationDTO
{
    public function __construct(
        public int $reservationId,
        public string $reason = 'manual_release',
        public ?int $partialQuantity = null,
    ) {}

    public static function fromRequest(array $validated, int $reservationId): self
    {
        return new self(
            reservationId: $reservationId,
            reason: $validated['reason'] ?? 'manual_release',
            partialQuantity: $validated['quantity'] ?? null,
        );
    }
}
