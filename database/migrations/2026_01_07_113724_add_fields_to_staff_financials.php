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
        Schema::table('staff_financials', function (Blueprint $table) {
            $table->tinyInteger('bank_entity')->nullable();
            $table->tinyInteger('pensioncontribution')->nullable();
            $table->string('cci')->nullable();
            $table->date('contract_end_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('staff_financials', function (Blueprint $table) {
            $table->dropColumn('bank_entity');
            $table->dropColumn('pensioncontribution');
            $table->dropColumn('cci');
            $table->dropColumn('contract_end_date');
        });
    }
};
