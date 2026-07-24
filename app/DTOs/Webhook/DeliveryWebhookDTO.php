<?php

namespace App\DTOs\Webhook;

readonly class DeliveryWebhookDTO
{
    public function __construct(
        public string $eventId,
        public string $shipmentUuid,
        public string $status,
        public ?string $trackingNumber = null,
    ) {}

    public static function fromRequest(array $validated): self
    {
        return new self(
            eventId: $validated['event_id'],
            shipmentUuid: $validated['shipment_id'],
            status: $validated['status'],
            trackingNumber: $validated['tracking_number'] ?? null,
        );
    }
}
