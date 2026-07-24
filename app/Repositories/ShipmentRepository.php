<?php

namespace App\Repositories;

use App\Contracts\Repositories\ShipmentRepositoryInterface;
use App\Enums\ShipmentStatus;
use App\Models\Shipment;
use Illuminate\Support\Collection;

class ShipmentRepository implements ShipmentRepositoryInterface
{
    public function create(array $data): Shipment
    {
        return Shipment::create($data);
    }
    public function findByUuid(string $uuid): ?Shipment
    {
        return Shipment::where('uuid',$uuid)->first();
    }
    public function getPending(int $limit = 50): Collection
    {
        return Shipment::where('status', ShipmentStatus::PENDING)
            ->limit($limit)
            ->get();
    }
    public function update(Shipment $shipment, array $data): void
    {
        $shipment->update($data);
    }
}
