<?php

use App\Http\Controllers\Api\InventoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('inventory')
    ->middleware(\App\Http\Middleware\IdempotencyMiddleware::class)
    ->group(function () {
        Route::post('/add-stock', [InventoryController::class, 'addStock']);
    });
