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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('discountable');
            $table->String('type')->required();
            $table->float('amount', 8, 2)->default(0);
            $table->boolean('active')->default(true);
            $table->json('exclude_product')
                ->nullable()
                ->default(null);

            $table->json('meta')->nullable()->default(null);
            $table->dateTime('issued_at');
            $table->dateTime('expired_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
