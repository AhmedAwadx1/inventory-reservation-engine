<?php

namespace App\Http\Controllers\Api;

use App\DTOs\Inventory\AddStockDTO;
use App\DTOs\Inventory\TransferStockDTO;
use App\Exceptions\InsufficientStockException;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddStockRequest;
use App\Http\Requests\TransferStockRequest;
use App\Http\Resources\InventoryResource;
use App\Models\Product;
use App\Models\Warehouse;
use App\Services\Inventory\InventoryService;
use Illuminate\Http\JsonResponse;

class InventoryController extends Controller
{
    public function __construct(private readonly InventoryService $inventoryService) {}

    /**
     * POST /api/inventory/add-stock
     */
    public function addStock(AddStockRequest $request): JsonResponse
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

    /**
     * POST /api/inventory/transfer
     */
    public function transfer(TransferStockRequest $request): JsonResponse
    {
        $validated = array_merge($request->validated(), [
            'idempotency_key' => $request->input('idempotency_key'),
        ]);

        $dto = TransferStockDTO::fromRequest($validated);

        try {
            $result = $this->inventoryService->transferStock($dto);

            return response()->json([
                'message' => __('messages.stock_transferred'),
                'data'    => [
                    'source'      => new InventoryResource($result['source']),
                    'destination' => new InventoryResource($result['destination']),
                ],
            ]);
        } catch (InsufficientStockException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    /**
     * GET /api/inventory/product/{productId}
     */
    public function byProduct(int $productId): JsonResponse
    {
        $inventory = $this->inventoryService->getProductInventory($productId);

        return response()->json([
            'data' => InventoryResource::collection($inventory),
        ]);
    }

    /**
     * GET /api/inventory/warehouse/{warehouseId}
     */
    public function byWarehouse(int $warehouseId): JsonResponse
    {
        $inventory = $this->inventoryService->getWarehouseInventory($warehouseId);

        return response()->json([
            'data' => InventoryResource::collection($inventory),
        ]);
    }


    //  know that 2 functions products and warehouses must be at the same flow controller->service->repo, I use it only to retrieve data to test EndPoints
    public function products()
    {
        $products = Product::all();
        return response()->json($products);
    }
    public function warehouses(){
        $wh = Warehouse::all();
        return response()->json($wh);
    }



}
