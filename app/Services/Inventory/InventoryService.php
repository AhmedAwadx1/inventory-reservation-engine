<?php

namespace App\Services\Inventory;

use App\Contracts\Repositories\InventoryRepositoryInterface;
use App\Contracts\Repositories\InventoryMovementRepositoryInterface;
use App\DTOs\Inventory\AddStockDTO;
use App\Enums\InventoryBucket;
use App\Enums\MovementType;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;



class InventoryService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private readonly InventoryRepositoryInterface $inventoryRepo,
        private readonly InventoryMovementRepositoryInterface $inventoryMovementRepo,
    ) {}

    public function addStock(AddStockDTO $dto) :Inventory{
        $existing= $this->inventoryMovementRepo->findByIdempotencyKey($dto->idempotencyKey);
        if($existing){
            return $this->inventoryRepo->findByProductAndWarehouse($dto->productId, $dto->warehouseId);
        }
        return DB::transaction(function () use ($dto){
            $inventory=$this->inventoryRepo->findForUpdate($dto->productId, $dto->warehouseId);

            if(!$inventory){
                $inventory=$this->inventoryRepo->create([
                    'product_id' => $dto->productId,
                    'warehouse_id' => $dto->warehouseId
                ]);
            }

            $this->inventoryRepo->incrementBucket(
                $inventory,
                'quantity_available',
                $dto->quantity
            );

            $this->inventoryMovementRepo->create([
                'uuid'            => Str::uuid(),
                'idempotency_key' => $dto->idempotencyKey,
                'product_id'      => $dto->productId,
                'warehouse_id'    => $dto->warehouseId,
                'type'            => MovementType::STOCK_IN,
                'from_bucket'     => InventoryBucket::EXTERNAL,
                'to_bucket'       => InventoryBucket::AVAILABLE,
                'quantity'        => $dto->quantity,
                'reason'          => $dto->reason,
            ]);
                  return $inventory->fresh();
        });


}

}
