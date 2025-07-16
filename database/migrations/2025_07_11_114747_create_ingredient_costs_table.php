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
        Schema::create('ingredient_costs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dish_ingredient_level_id')->nullable();
            $table->foreign('dish_ingredient_level_id')->references('id')->on('dish_ingredient_levels')->cascadeOnDelete();
            $table->decimal('base_cost',10,4)->nullable();
            $table->decimal('cost_percentage',10,4)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredient_costs');
    }
};
