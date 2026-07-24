<?php

namespace App\Enums;

use App\Enums\Concerns\HasTranslatableLabel;

enum WebhookStatus: int
{
    use HasTranslatableLabel;

    case RECEIVED  = 1;
    case PROCESSED = 2;
    case FAILED    = 3;
}
