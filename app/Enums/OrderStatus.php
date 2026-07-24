<?php

namespace App\Enums;

use App\Enums\Concerns\HasTranslatableLabel;

enum OrderStatus: int
{
    use HasTranslatableLabel;

    case PENDING           = 1;
    case CONFIRMED         = 2;
    case PARTIALLY_SHIPPED = 3;
    case SHIPPED           = 4;
    case DELIVERED         = 5;
    case CANCELLED         = 6;
}
