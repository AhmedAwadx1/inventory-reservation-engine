<?php

namespace Database\Seeders;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        $products   = Product::all();
        $warehouses = Warehouse::all();

        /**
         * [
         *  0 => mghzn cairo
         *  1=> mghzn alex
         *  2=> mghzn assuit
         *  3=> mghzn el delta
         * ]
         */

        $stockMap = [
            // product_index => [CAI, ALX, AST, DLT]
            0 => [200, 150, 50, 100],   // لابتوب
            1 => [300, 200, 80, 120],   // شاشة
            2 => [500, 400, 200, 300],  // كيبورد
            3 => [600, 500, 250, 350],  // ماوس
        ];

        foreach ($products as $pIndex => $product) {
            foreach ($warehouses as $wIndex => $warehouse) {
                Inventory::create([
                    'product_id'         => $product->id,
                    'warehouse_id'       => $warehouse->id,
                    'quantity_available'  => $stockMap[$pIndex][$wIndex],
                    'quantity_reserved'   => 0,
                    'quantity_picked'     => 0,
                    'quantity_packed'     => 0,
                    'quantity_shipped'    => 0,
                    'quantity_delivered'  => 0,
                ]);
            }
        }
    }
}
