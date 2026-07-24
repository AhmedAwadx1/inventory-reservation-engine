<?php

namespace App\Repositories;

use App\Contracts\Repositories\ReservationRepositoryInterface;
use App\Enums\ReservationStatus;
use App\Models\Reservation;
use Illuminate\Support\Collection;

class ReservationRepository implements ReservationRepositoryInterface
{
    public function create(array $data): Reservation{
        return Reservation::create($data);
    }
    public function findByUuid(string $uuid): ?Reservation {
        return Reservation::where('uuid',$uuid)->first();
    }
    public function findById(int $id): ?Reservation {
        return Reservation::find($id);
    }
    public function findByIdempotencyKey(string $key): ?Reservation {
       return  Reservation::where('idempotency_key',$key)->first();
    }
    //get reservation by expires_at
    public function getExpired(int $limit = 100): Collection {
        return Reservation::where('status',ReservationStatus::ACTIVE)
            ->where('expires_at', "<=" , now())
            ->limit($limit)
            ->get();
    }
    public function getActiveByOrderId(int $orderId): Collection
    {
        return Reservation::where('order_id',$orderId)
            ->where('status' , ReservationStatus::ACTIVE)
            ->get();
    }
    public function updateStatus(Reservation $reservation, array $data): void
    {
        $reservation->update($data);
    }
}
