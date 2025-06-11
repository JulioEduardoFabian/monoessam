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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cafe_id')->nullable();
            $table->foreign('cafe_id')->references('id')->on('cafes')->nullOnDelete();
            $table->decimal('total_amount', 10, 2)->default(0.00)->nullable();
            $table->date('date')->nullable();
            $table->string('serial_number')->nullable();
            $table->unsignedBigInteger('sale_type_id')->nullable();
            $table->foreign('sale_type_id')->references('id')->on('sale_types')->nullOnDelete();
            $table->unsignedBigInteger('payment_method_id')->nullable();
            $table->foreign('payment_method_id')->references('id')->on('payment_methods')->nullOnDelete();
            $table->unsignedBigInteger('business_id')->nullable();
            $table->foreign('business_id')->references('id')->on('businesses')->nullOnDelete();
            $table->string('business_name')->nullable();
            $table->string('business_ruc')->nullalbe();
            $table->string('business_legal_name')->nullable();
            $table->string('business_fiscal_address')->nullable();
          // numbers 
            $table->decimal('total_discounts',12,4)->default(0.00)->nullable();
            $table->decimal('total_non_taxable_operations',12,4)->default(0.00)->nullable();
            $table->decimal('total_taxable_operations',12,4)->default(0.00)->nullable();
            $table->decimal('total_unaffected_operations',12,4)->default(0.00)->nullable();
            $table->decimal('total_exonerated_operations',12,4)->default(0.00)->nullable();
            $table->decimal('total_exported_operations',12,4)->default(0.00)->nullable();
            $table->decimal('total_igv', 12, 4)->default(0.00)->nullable();
            $table->decimal('total_isc', 12, 4)->default(0.00)->nullable();
            $table->decimal('total_other_taxes', 12, 4)->default(0.00)->nullable();
            $table->decimal('total_other_charges', 12, 4)->default(0.00)->nullable();
            $table->decimal('total', 12, 4)->default(0.00)->nullable();
            $table->tinyInteger('status')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
