<?php

namespace App\Services\Inventory;

use App\Contracts\Repositories\InventoryRepositoryInterface;
use App\Contracts\Repositories\InventoryMovementRepositoryInterface;
use App\DTOs\Inventory\AddStockDTO;
use App\DTOs\Inventory\TransferStockDTO;
use App\Enums\InventoryBucket;
use App\Enums\MovementType;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\DTOs\Inventory\MoveBucketDTO;
use App\Exceptions\InsufficientStockException;



class InventoryService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private readonly InventoryRepositoryInterface         $inventoryRepo,
        private readonly InventoryMovementRepositoryInterface $inventoryMovementRepo,
    )
    {
    }

    public function addStock(AddStockDTO $dto): Inventory
    {
        $existing = $this->inventoryMovementRepo->findByIdempotencyKeyAndType($dto->idempotencyKey, MovementType::STOCK_IN);
        if ($existing) {
            return $this->inventoryRepo->findByProductAndWarehouse($dto->productId, $dto->warehouseId);
        }
        return DB::transaction(function () use ($dto) {
            $inventory = $this->inventoryRepo->findForUpdate($dto->productId, $dto->warehouseId);

            if (!$inventory) {
                $inventory = $this->inventoryRepo->create([
                    'product_id'   => $dto->productId,
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

    public function transferStock(TransferStockDTO $dto): array
    {
        $existing = $this->inventoryMovementRepo->findByIdempotencyKeyAndType($dto->idempotencyKey, MovementType::TRANSFER_OUT);
        if ($existing) {
            return [
                'source'      => $this->inventoryRepo->findByProductAndWarehouse($dto->productId, $dto->sourceWarehouseId),
                'destination' => $this->inventoryRepo->findByProductAndWarehouse($dto->productId, $dto->destinationWarehouseId),
            ];
        }
        return DB::transaction(function () use ($dto) {
            $source = $this->inventoryRepo->findForUpdate($dto->productId, $dto->sourceWarehouseId);
            if (!$source || $source->quantity_available < $dto->quantity) {
                throw new InsufficientStockException(
                    __('errors.cannot_move_quantity', [
                        'quantity' => $dto->quantity,
                        'bucket'   => InventoryBucket::AVAILABLE->label(),
                        'current'  => $source?->quantity_available ?? 0,
                    ])
                );
            }
            $this->inventoryRepo->decrementBucket($source, 'quantity_available', $dto->quantity);
            $destination = $this->inventoryRepo->findForUpdate($dto->productId, $dto->destinationWarehouseId);
            if (!$destination) {
                $destination = $this->inventoryRepo->create([
                    'product_id'   => $dto->productId,
                    'warehouse_id' => $dto->destinationWarehouseId,
                ]);
            }
            $this->inventoryRepo->incrementBucket($destination, 'quantity_available', $dto->quantity);
            $this->inventoryMovementRepo->create([
                'uuid'            => Str::uuid(),
                'idempotency_key' => $dto->idempotencyKey,
                'product_id'      => $dto->productId,
                'warehouse_id'    => $dto->sourceWarehouseId,
                'type'            => MovementType::TRANSFER_OUT,
                'from_bucket'     => InventoryBucket::AVAILABLE,
                'to_bucket'       => InventoryBucket::EXTERNAL,
                'quantity'        => $dto->quantity,
                'reason'          => $dto->reason,
            ]);
            $this->inventoryMovementRepo->create([
                'uuid'            => Str::uuid(),
                'idempotency_key' => $dto->idempotencyKey . ':in',
                'product_id'      => $dto->productId,
                'warehouse_id'    => $dto->destinationWarehouseId,
                'type'            => MovementType::TRANSFER_IN,
                'from_bucket'     => InventoryBucket::EXTERNAL,
                'to_bucket'       => InventoryBucket::AVAILABLE,
                'quantity'        => $dto->quantity,
                'reason'          => $dto->reason,
            ]);
            return [
                'source'      => $source->fresh(),
                'destination' => $destination->fresh(),
            ];
        });
    }

    public function moveBucket(MoveBucketDTO $dto): void
    {
        $existing = $this->inventoryMovementRepo->findByIdempotencyKeyAndType($dto->idempotencyKey, $dto->type);
        if ($existing) {
            return;
        }
        $inventory = $this->inventoryRepo->findForUpdate($dto->productId, $dto->warehouseId);
        if (!$inventory) {
            throw new InsufficientStockException(
                __('errors.no_inventory_record', [
                    'product'   => $dto->productId,
                    'warehouse' => $dto->warehouseId,
                ])
            );
        }
        $fromColumn = $dto->fromBucket->columnName();
        if ($inventory->{$fromColumn} < $dto->quantity) {
            throw new InsufficientStockException(
                __('errors.cannot_move_quantity', [
                    'quantity' => $dto->quantity,
                    'bucket'   => $dto->fromBucket->label(),
                    'current'  => $inventory->{$fromColumn},
                ])
            );
        }
        $this->inventoryRepo->decrementBucket($inventory, $fromColumn, $dto->quantity);
        $this->inventoryRepo->incrementBucket($inventory, $dto->toBucket->columnName(), $dto->quantity);
        $this->inventoryMovementRepo->create([
            'uuid'            => Str::uuid(),
            'idempotency_key' => $dto->idempotencyKey,
            'product_id'      => $dto->productId,
            'warehouse_id'    => $dto->warehouseId,
            'reservation_id'  => $dto->reservationId,
            'shipment_id'     => $dto->shipmentId,
            'order_id'        => $dto->orderId,
            'type'            => $dto->type,
            'from_bucket'     => $dto->fromBucket,
            'to_bucket'       => $dto->toBucket,
            'quantity'        => $dto->quantity,
            'reason'          => $dto->reason,
            'metadata'        => $dto->metadata,
        ]);
    }


    public function getProductInventory(int $productId)
    {
        return $this->inventoryRepo->getByProduct($productId);
    }


    public function getWarehouseInventory(int $warehouseId)
    {
        return $this->inventoryRepo->getByWarehouse($warehouseId);
    }
}
