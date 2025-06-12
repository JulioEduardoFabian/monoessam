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
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('total_amount');
            $table->dropColumn('business_name');
            $table->dropColumn('business_ruc');
            $table->dropColumn('business_legal_name');
            $table->dropColumn('business_fiscal_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->decimal('total_amount', 10, 2)->default(0.00)->nullable();
            $table->string('business_name')->nullable();
            $table->string('business_ruc')->nullable();
            $table->string('business_legal_name')->nullable();
            $table->string('business_fiscal_address')->nullable();
        });
    }
};
