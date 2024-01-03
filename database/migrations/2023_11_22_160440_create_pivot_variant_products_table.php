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
        Schema::create('pivot_variant_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('variant_product_id');
            $table->unsignedBigInteger('variant_prop_id');
            $table->timestamps();

            $table->foreign('variant_product_id')->references('id')->on('variant_products');
            $table->foreign('variant_prop_id')->references('id')->on('variant_props');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pivot_variant_products');
    }
};
