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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number');
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->double('total_item_price', 8, 2)
                ->default(0);
            $table->double('total_item_price_after_discount', 8, 2)
                ->default(0);
            $table->double('total_shipping_cost', 8, 2)
                ->default(0);
            $table->string('coupon_code')
                ->nullable();
            $table->string('coupon_type')
                ->nullable();
            $table->integer('coupon_reduction')
                ->nullable();
            $table->json('coupon_meta')
                ->nullable();
            $table->json('additional_info')
                ->nullable();
            $table->timestamp('canceled_at')
                ->nullable();
            $table->timestamp('completed_at')
                ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
