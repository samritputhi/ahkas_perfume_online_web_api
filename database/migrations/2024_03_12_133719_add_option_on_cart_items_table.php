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

        Schema::table('cart_items', function (Blueprint $table) {
            $table->json('options')->nullable();
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->json('options')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropColumn('options');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('options');
        });
    }
};
