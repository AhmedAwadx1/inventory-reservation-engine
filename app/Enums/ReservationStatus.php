<?php

namespace App\Enums;

use App\Enums\Concerns\HasTranslatableLabel;

enum ReservationStatus: int
{
    use HasTranslatableLabel;

    case ACTIVE   = 1;
    case RELEASED = 2;
    case CONSUMED = 3;
    case EXPIRED  = 4;
}
