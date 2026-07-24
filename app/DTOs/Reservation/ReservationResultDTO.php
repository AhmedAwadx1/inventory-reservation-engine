<?php

namespace App\DTOs\Reservation;

use App\Models\Reservation;

readonly class ReservationResultDTO
{
    public function __construct(
        public Reservation $reservation,
        public int $quantityReserved,
        public int $quantityUnfulfilled,
        public bool $isDuplicate,
    ) {}

    /**
     * Check if reservation was only partially fulfilled.
     */
    public function isPartial(): bool
    {
        return $this->quantityUnfulfilled > 0;
    }
}
