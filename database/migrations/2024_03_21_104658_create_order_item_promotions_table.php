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
        Schema::create('order_item_promotions', function (Blueprint $table) {
            $table
                ->foreignId('order_item_id')
                ->constrained()
                ->cascadeOnDelete();
            $table
                ->foreignId('product_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->integer('qty');
            $table->integer('discount_percent')->default(0);
            $table->timestamps();
            $table->primary(['order_item_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_item_promotions');
    }
};
