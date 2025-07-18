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
                 Schema::dropIfExists('ingredient_city_provider');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('ingredient_city_provider', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ingredient_id')->nullable();
            $table->foreign('ingredient_id')->references('id')->on('ingredients')->cascadeOnDelete();
            $table->unsignedBigInteger('provider_id')->nullable();
            $table->foreign('provider_id')->references('id')->on('providers')->cascadeOnDelete();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id')->references('id')->on('cities')->cascadeOnDelete();
            $table->decimal('cost_price',10,2)->nullable();
            $table->unsignedBigInteger('measurement_unit_id')->nullable();
            $table->foreign('measurement_unit_id')->references('id')->on('measurement_units')->nullOnDelete();
            $table->string('presentation')->nullable();
            $table->timestamps();
        });
    }
};
