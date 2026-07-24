<?php
namespace App\Contracts;
use App\DTOs\Shipment\ShippingResultDTO;
use App\Models\Shipment;
interface ShippingProviderInterface
{
    public function ship(Shipment $shipment): ShippingResultDTO;
}
