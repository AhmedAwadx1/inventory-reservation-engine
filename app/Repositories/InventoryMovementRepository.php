<?php

namespace App\Repositories;

use App\Contracts\Repositories\InventoryMovementRepositoryInterface;
use App\Enums\MovementType;
use App\Models\InventoryMovement;

class InventoryMovementRepository implements InventoryMovementRepositoryInterface
{
    public function create(array $data):InventoryMovement{
        return  InventoryMovement::create($data);
    }

    public function findByIdempotencyKey(string $key):?InventoryMovement {
        return InventoryMovement::where('idempotency_key',$key)->first();
    }

    public function findByIdempotencyKeyAndType(string $key, MovementType $type): ?InventoryMovement {
        return InventoryMovement::where('idempotency_key', $key)
            ->where('type', $type)
            ->first();
    }

    public function getByProductAndWarehouse(int $productId , int $warehouseId){
        return InventoryMovement::where('product_id',$productId)
            ->where('warehouse_id',$warehouseId)
            ->orderByDesc('created_at')
            ->get();
    }
}

