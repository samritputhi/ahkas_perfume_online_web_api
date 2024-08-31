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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId('cart_id')
                ->constrained()
                ->cascadeOnDelete();
            $table
                ->foreignId('product_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->integer('qty');
            $table->integer('discount_percent')->default(0);
            $table->double('price_per_item', 8, 2)->default(0);
            $table->double('price_per_item_after_discount', 8, 2)->default(0);
            $table->double('total_item_price', 8, 2)->default(0);
            $table->double('total_item_price_after_discount', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
