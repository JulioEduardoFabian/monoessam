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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sale_id')->nullable();
            $table->foreign('sale_id')->references('id')->on('sales')->nullOnDelete();
            $table->unsignedBigInteger('dinner_id')->nullable();
            $table->foreign('dinner_id')->references('id')->on('dinners')->nullOnDelete();
            $table->string('dinner_name')->nullable();
            $table->string('dni')->nullable();
            $table->string('subdealership_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
