<?php
namespace App\Contracts\Repositories;

use App\Models\Order;
use App\Models\OrderItem;
interface OrderRepositoryInterface
{
    public function findById(int $id): ?Order;
    public function findItemById(int $id): ?OrderItem;
    public function updateOrder(Order $order, array $data): void;
    public function updateItem(OrderItem $item, array $data): void;

}
