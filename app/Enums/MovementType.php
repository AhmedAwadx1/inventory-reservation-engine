<?php

namespace App\Enums;

use App\Enums\Concerns\HasTranslatableLabel;

enum MovementType: int
{
    use HasTranslatableLabel;

    case STOCK_IN            = 1;
    case RESERVATION         = 2;
    case RESERVATION_RELEASE = 3;
    case PICK                = 4;
    case PACK                = 5;
    case SHIP                = 6;
    case DELIVER             = 7;
    case TRANSFER_OUT        = 8;
    case TRANSFER_IN         = 9;
    case ADJUSTMENT          = 10;
    case EXPIRATION_RELEASE  = 11;
}
