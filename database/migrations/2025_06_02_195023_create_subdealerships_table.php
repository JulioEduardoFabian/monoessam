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
        Schema::create('subdealerships', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('ruc')->nullable();
            $table->string('fiscal_address')->nullable();
            $table->string('legal_address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->unsignedBigInteger('dealership_id')->nullable();
            $table->foreign('dealership_id')->references('id')->on('dealerships')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subdealerships');
    }
};
