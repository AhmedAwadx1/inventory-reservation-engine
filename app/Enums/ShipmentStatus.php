<?php

namespace App\Enums;

use App\Enums\Concerns\HasTranslatableLabel;

enum ShipmentStatus: int
{
    use HasTranslatableLabel;

    case PENDING    = 1;
    case PROCESSING = 2;
    case SHIPPED    = 3;
    case DELIVERED  = 4;
    case FAILED     = 5;
}
