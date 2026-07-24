<?php

namespace App\Repositories;

use App\Contracts\Repositories\WebhookLogRepositoryInterface;
use App\Models\WebhookLog;

class WebhookLogRepository implements WebhookLogRepositoryInterface
{
    public function create(array $data): WebhookLog
    {
        return WebhookLog::create($data);
    }

    public function findByEventId(string $eventId): ?WebhookLog
    {
        return WebhookLog::where('event_id',$eventId)->first();
    }

    public function update(WebhookLog $log, array $data): void
    {
        $log->update($data);
    }
}
