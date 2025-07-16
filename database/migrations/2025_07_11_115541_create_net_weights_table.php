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
        Schema::create('net_weights', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dish_ingredient_level_id')->nullable();
            $table->foreign('dish_ingredient_level_id')->references('id')->on('dish_ingredient_levels')->cascadeOnDelete();
            $table->decimal('amount',10,4)->nullable();
            $table->unsignedBigInteger('unit_measurement_id')->nullable();
            $table->foreign('unit_measurement_id')->references('id')->on('measurement_units')->nullOnDelete();
            $table->decimal('percentage',10,4)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('net_weights');
    }
};
