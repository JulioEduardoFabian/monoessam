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
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('presentation')->nullable();
            $table->decimal('amount',7,2)->nullable();
            $table->string('measurement_unit')->nullable();
            $table->decimal('calories',7,2)->nullable();
            $table->decimal('liquid_waste',7,4)->nullable();
            $table->decimal('solid_waste',7,4)->nullable();
            $table->unsignedBigInteger('ingredient_category_id')->nullable();
            $table->foreign('ingredient_category_id')->references('id')->on('ingredient_categories')->cascadeOnUpdate()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredients');
    }
};
