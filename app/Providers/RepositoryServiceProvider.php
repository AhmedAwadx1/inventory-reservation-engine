<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Repositories\InventoryRepositoryInterface;
use App\Contracts\Repositories\InventoryMovementRepositoryInterface;
use App\Contracts\Repositories\ReservationRepositoryInterface;
use App\Contracts\Repositories\ShipmentRepositoryInterface;
use App\Contracts\Repositories\OrderRepositoryInterface;
use App\Contracts\Repositories\WebhookLogRepositoryInterface;
use App\Repositories\InventoryRepository;
use App\Repositories\InventoryMovementRepository;
use App\Repositories\ReservationRepository;
use App\Repositories\ShipmentRepository;
use App\Repositories\OrderRepository;
use App\Repositories\WebhookLogRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(InventoryRepositoryInterface::class, InventoryRepository::class);
        $this->app->bind(InventoryMovementRepositoryInterface::class, InventoryMovementRepository::class);
        $this->app->bind(ReservationRepositoryInterface::class, ReservationRepository::class);
        $this->app->bind(ShipmentRepositoryInterface::class, ShipmentRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(WebhookLogRepositoryInterface::class, WebhookLogRepository::class);
    }
}
