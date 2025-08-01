<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventory_item_stock', function (Blueprint $table) {
           $table->id();
           $table->foreignId('warehouse_id')->constrained('warehouses')->onDelete('cascade');
           $table->foreignId('inventory_item_id')->constrained('inventory_items')->onDelete('cascade');
           $table->integer('quantity')->default(0);
           $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_item_stock');
    }
};
