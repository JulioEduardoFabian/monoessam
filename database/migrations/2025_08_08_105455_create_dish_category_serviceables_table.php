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
        Schema::create('dish_category_serviceables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dish_category_id')->nullable();
            $table->foreign('dish_category_id')->references('id')->on('dish_categories')->onDelete('cascade');
            $table->unsignedBigInteger('serviceable_id')->nullable();
            $table->foreign('serviceable_id')->references('id')->on('serviceables')->onDelete('cascade');
            $table->decimal('serving_amount', 10, 2)->nullable();
            $table->unsignedBigInteger('measurement_unit_id')->nullable();
            $table->foreign('measurement_unit_id')->references('id')->on('measurement_units')->nullOnDelete();
            $table->decimal('serving_percentaje',10,2)->nullable();
            $table->decimal('lower_limit_cost', 10, 2)->nullable();
            $table->decimal('total_lower_limit_cost', 10, 2)->nullable();
            $table->decimal('upper_limit_cost', 10, 2)->nullable();
            $table->decimal('total_upper_limit_cost', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dish_category_serviceables');
    }
};
