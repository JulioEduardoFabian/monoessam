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
        Schema::create('dinners', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('dni')->nullable();
            $table->string('phone')->nullable();
            $table->unsignedBigInteger('subdealership_id')->nullable();
            $table->foreign('subdealership_id')->references('id')->on('subdealerships')->nullOnDelete();
            $table->unsignedBigInteger('cafe_id')->nullable();
            $table->foreign('cafe_id')->references('id')->on('cafes')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dinners');
    }
};
