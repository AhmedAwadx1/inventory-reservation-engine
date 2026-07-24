<?php
namespace App\Contracts\Repositories;

use App\Models\Reservation;
use Illuminate\Support\Collection;



interface ReservationRepositoryInterface
{
    public function create(array $data): Reservation;
    public function findByUuid(string $uuid): ?Reservation;
    public function findById(int $id): ?Reservation;
    public function findByIdempotencyKey(string $key): ?Reservation;
   //get reservation by expires_at
     public function getExpired(int $limit = 100): Collection;
    public function getActiveByOrderId(int $orderId): Collection;
    public function updateStatus(Reservation $reservation, array $data): void;

}
