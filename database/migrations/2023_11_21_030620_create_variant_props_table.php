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
        Schema::create('variant_props', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->unsignedBigInteger('variant_type_id'); 
            $table->timestamps();

            $table->foreign('variant_type_id')->references('id')->on('variant_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variant_props');
    }
};
