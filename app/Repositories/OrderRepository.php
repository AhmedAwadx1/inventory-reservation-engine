<?php

namespace App\Repositories;

use App\Contracts\Repositories\OrderRepositoryInterface;
use App\Models\Order;
use App\Models\OrderItem;

class OrderRepository implements OrderRepositoryInterface
{
    public function findById(int $id): ?Order
    {
        return Order::with('items')->find($id);
    }
    public function findItemById(int $id): ?OrderItem
    {
        return OrderItem::find($id);
    }
    public function updateOrder(Order $order, array $data): void
    {
        $order->update($data);
    }
    public function updateItem(OrderItem $item, array $data): void
    {
        $item->update($data);
    }
}
