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
        Schema::create('dish_category_dish', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dish_category_id')->nullable();
            $table->foreign('dish_category_id')->references('id')->on('dish_categories')->cascadeOnDelete();
            $table->unsignedBigInteger('dish_id')->nullable();
            $table->foreign('dish_id')->references('id')->on('dishes')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dish_category_dish');
    }
};
