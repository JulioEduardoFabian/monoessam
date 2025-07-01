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
        Schema::dropIfExists('dish_level');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('dish_level', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dish_id')->nullable();
            $table->foreign('dish_id')->references('id')->on('dishes')->cascadeOnDelete();
            $table->unsignedBigInteger('level_id')->nullable();
            $table->foreign('level_id')->references('id')->on('levels')->cascadeOnDelete();
            $table->timestamps();
        });
    }
};
