<?php

namespace App\Http\Controllers\Api;

use App\DTOs\Inventory\AddStockDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddStockRequest;
use App\Http\Resources\InventoryResource;
use App\Services\Inventory\InventoryService;

class InventoryController extends Controller
{
    public function __construct(private readonly InventoryService $inventoryService){}
    public function addStock(AddStockRequest $request)
    {
        $validated = array_merge($request->validated(), [
            'idempotency_key' => $request->input('idempotency_key'),
        ]);

        $dto = AddStockDTO::fromRequest($validated);
        $inventory = $this->inventoryService->addStock($dto);

        return response()->json([
            'message' => __('messages.stock_added'),
            'data'    => new InventoryResource($inventory),
        ], 201);
    }
}
