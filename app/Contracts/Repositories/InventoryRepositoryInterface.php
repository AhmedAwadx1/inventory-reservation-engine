<?php
namespace App\Contracts\Repositories;

use App\Models\Inventory;

interface InventoryRepositoryInterface
{
    /**
    ->lockForUpdate()
     * */
    public function findForUpdate(int $productId , int $warehouseId): ?Inventory;
    // only find - no actions
     public function findByProductAndWarehouse(int $productId , int $warehouseId): ?Inventory;
     //create
    public function create (array $data):Inventory;
    /** : quantity_available += 5 */
    public function incrementBucket(Inventory $inventory, string $column, int $quantity): void;
    /** : quantity_available -= 5 */
    public function decrementBucket(Inventory $inventory, string $column, int $quantity): void;
    public function getByProduct(int $productId);
    public function getByWarehouse(int $warehouseId);

}
