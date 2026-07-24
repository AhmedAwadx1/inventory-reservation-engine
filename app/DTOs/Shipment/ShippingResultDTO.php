<?php

namespace App\DTOs\Shipment;

readonly class ShippingResultDTO
{
    public function __construct(
        public string $status,
        public ?string $trackingNumber = null,
        public ?string $providerReference = null,
        public ?string $error = null,
    ) {}

    public function isSuccess(): bool
    {
        return $this->status === 'success';
    }
}
