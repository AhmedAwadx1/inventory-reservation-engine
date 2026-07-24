<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained()->cascadeOnDelete();

            // Stock buckets — all unsigned to prevent negative values at DB level
            $table->unsignedInteger('quantity_available')->default(0);
            $table->unsignedInteger('quantity_reserved')->default(0);
            $table->unsignedInteger('quantity_picked')->default(0);
            $table->unsignedInteger('quantity_packed')->default(0);
            $table->unsignedInteger('quantity_shipped')->default(0);
            $table->unsignedInteger('quantity_delivered')->default(0);

            $table->unsignedInteger('version')->default(1);
            $table->timestamps();

            $table->unique(['product_id', 'warehouse_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory');
    }
};
