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
        Schema::create('sale_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sale_id')->nullable();
            $table->foreign('sale_id')->references('id')->on('sales')->nullOnDelete();
            $table->unsignedBigInteger('service_id')->nullable();
            $table->foreign('service_id')->references('id')->on('services')->nullOnDelete();
            $table->string('code')->nullable();
            $table->string('service_name')->nullable();
            $table->integer('amount')->nullable();
            $table->string('um')->nullable();
            $table->text('description')->nullable();
            $table->decimal('unit_value',12,4)->nullable();
            $table->decimal('unit_price',12,4)->nullable();
            $table->decimal('sale_value',12,4)->nullable();
            $table->decimal('igv',12,4)->nullable();
            $table->decimal('total',12,4)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_details');
    }
};
