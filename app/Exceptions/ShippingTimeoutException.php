<?php

namespace App\Exceptions;

use RuntimeException;

class ShippingTimeoutException extends RuntimeException
{
public function __construct(string $message = '')
{
    parent::__construct($message?:'Shipping provider timed out');
}
}
