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
        Schema::create('ticket_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticket_id')->nullable();
            $table->foreign('ticket_id')->references('id')->on('tickets')->nullOnDelete();
            $table->unsignedBigInteger('service_id')->nullable();
            $table->foreign('service_id')->references('id')->on('services')->nullOnDelete();
            $table->string('code')->nullable();
            $table->string('service_name')->nullable();
            $table->integer('amount')->nullable();
            $table->string('um')->nullable();
            $table->tinyInteger('service_type')->nullable();
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
        Schema::dropIfExists('ticket_details');
    }
};
