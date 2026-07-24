<?php
namespace App\Contracts\Repositories;

use App\Models\Shipment;
use Illuminate\Support\Collection;



interface ShipmentRepositoryInterface
{
    public function create(array $data): Shipment;
    public function findByUuid(string $uuid): ?Shipment;
    public function getPending(int $limit = 50): Collection;
    public function update(Shipment $shipment, array $data): void;

}
