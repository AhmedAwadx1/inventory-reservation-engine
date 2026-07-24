<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'لابتوب HP ProBook',     'sku' => 'LAP-HP-001',   'description' => 'لابتوب HP ProBook 450 G10', 'reservation_ttl_minutes' => 30],
            ['name' => 'شاشة Dell 27"',          'sku' => 'MON-DELL-001', 'description' => 'شاشة Dell UltraSharp 27 بوصة', 'reservation_ttl_minutes' => 30],
            ['name' => 'كيبورد لوجيتك',          'sku' => 'KEY-LOG-001',  'description' => 'كيبورد Logitech MX Keys', 'reservation_ttl_minutes' => 15],
            ['name' => 'ماوس لاسلكي',            'sku' => 'MOU-LOG-001',  'description' => 'ماوس Logitech MX Master 3S', 'reservation_ttl_minutes' => 15],
        ];

        foreach ($products as $product) {
            Product::create([
                'uuid'                    => Str::uuid(),
                'name'                    => $product['name'],
                'sku'                     => $product['sku'],
                'description'             => $product['description'],
                'reservation_ttl_minutes' => $product['reservation_ttl_minutes'],
            ]);
        }
    }
}
