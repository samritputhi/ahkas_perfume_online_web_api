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
        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('confirm_at')
                ->nullable();
            $table->timestamp('delivery_at')
                ->nullable();
            $table->timestamp('rejected_at')
                ->nullable();
            $table->string('status')->default('pending');
            $table->string('note')->default('');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('note');
            $table->dropColumn('confirm_at');
            $table->dropColumn('delivery_at');
            $table->dropColumn('rejected_at');
        });
    }
};
