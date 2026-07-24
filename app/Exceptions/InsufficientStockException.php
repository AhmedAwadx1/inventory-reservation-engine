<?php

namespace App\Exceptions;

use RuntimeException;

class InsufficientStockException extends RuntimeException
 {
public function __construct(string $message = '')
{
    parent::__construct($message ?: __('errors.insufficient_stock'));
}
 }
