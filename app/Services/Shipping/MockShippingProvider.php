<?php

use App\Contracts\ShippingProviderInterface;
use App\DTOs\Shipment\ShippingResultDTO;
use App\Models\Shipment;

class MockShippingProvider implements ShippingProviderInterface
{
       public function ship(Shipment $shipment): ShippingResultDTO {
           // Simulate shipping provider API delay
        usleep(100_000);
        if (rand(1, 100) <= 80) {
            return new ShippingResultDTO(
                status: 'success',
                trackingNumber: 'TRK-' . strtoupper(Str::random(10)),
                providerReference: 'REF-' . Str::uuid(),
            );
        }
        return new ShippingResultDTO(
            status: 'failed',
            error: 'Mock shipping provider: random failure',
        );
    }
}


