<?php
namespace App\Contracts\Repositories;

use App\Models\WebhookLog;
interface WebhookLogRepositoryInterface
{
    public function create(array $data): WebhookLog;

    public function findByEventId(string $eventId): ?WebhookLog;

    public function update(WebhookLog $log, array $data): void;
}
