<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        $warehouses = [
            ['name' => 'مخزن القاهرة',    'code' => 'CAI', 'address' => 'المنطقة الصناعية، مدينة بدر، القاهرة'],
            ['name' => 'مخزن الإسكندرية', 'code' => 'ALX', 'address' => 'المنطقة الحرة، برج العرب، الإسكندرية'],
            ['name' => 'مخزن أسيوط',      'code' => 'AST', 'address' => 'المنطقة الصناعية، أسيوط'],
            ['name' => 'مخزن الدلتا',     'code' => 'DLT', 'address' => 'المنطقة الصناعية، طنطا، الغربية'],
        ];

        foreach ($warehouses as $warehouse) {
            Warehouse::create([
                'uuid'      => Str::uuid(),
                'name'      => $warehouse['name'],
                'code'      => $warehouse['code'],
                'address'   => $warehouse['address'],
                'is_active' => true,
            ]);
        }
    }
}
