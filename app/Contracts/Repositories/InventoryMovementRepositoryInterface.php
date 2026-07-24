<?php
namespace App\Contracts\Repositories;

use App\Enums\MovementType;
use App\Models\InventoryMovement;

interface InventoryMovementRepositoryInterface
{
 public function create(array $data):InventoryMovement;

 public function findByIdempotencyKey(string $key):?InventoryMovement ;

 public function findByIdempotencyKeyAndType(string $key, MovementType $type): ?InventoryMovement;

 public function getByProductAndWarehouse(int $productId , int $warehouseId);

}
