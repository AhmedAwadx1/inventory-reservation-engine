<?php

use App\Http\Controllers\Api\InventoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('inventory')->group(function () {

    // POST routes — تحتاج X-Idempotency-Key
    Route::middleware(\App\Http\Middleware\IdempotencyMiddleware::class)->group(function () {
        Route::post('/add-stock', [InventoryController::class, 'addStock']);
        Route::post('/transfer', [InventoryController::class, 'transfer']);
    });
    Route::get('/products', [InventoryController::class, 'products']);
    Route::get('/warehouses', [InventoryController::class, 'warehouses']);
    Route::get('/product/{productId}', [InventoryController::class, 'byProduct']);
    Route::get('/warehouse/{warehouseId}', [InventoryController::class, 'byWarehouse']);
});
