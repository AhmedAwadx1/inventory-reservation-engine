<?php

namespace App\Repositories;

use App\Contracts\Repositories\InventoryRepositoryInterface;
use App\Models\Inventory;

class InventoryRepository implements InventoryRepositoryInterface
{
    public function findForUpdate(int $productId , int $warehouseId): ?Inventory{

        return Inventory::where('product_id', $productId)
            ->where('warehouse_id', $warehouseId)
            ->lockForUpdate()
            ->first();
    }
    public function findByProductAndWarehouse(int $productId , int $warehouseId): ?Inventory{

        return Inventory::where('product_id', $productId)
            ->where('warehouse_id', $warehouseId)
            ->first();
    }
    public function create (array $data):Inventory {
        return Inventory::create($data);
    }
    public function incrementBucket(Inventory $inventory, string $column, int $quantity): void{
        $inventory->increment($column ,$quantity );
    }
    public function decrementBucket(Inventory $inventory, string $column, int $quantity): void{
        $inventory->decrement($column ,$quantity );
    }
    public function getByProduct(int $productId){
        return Inventory::where('product_id' ,$productId )->with('warehouse','product')->get();
    }
    public function getByWarehouse(int $warehouseId){
        return Inventory::where('warehouse_id' ,$warehouseId )->with('product','warehouse')->get();

    }
}
