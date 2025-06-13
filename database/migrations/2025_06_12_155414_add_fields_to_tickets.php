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
        Schema::table('tickets', function (Blueprint $table) {
            $table->string('serial_number')->nuallable();
            $table->string('subdealership_ruc')->nullable();
            $table->decimal('price_value')->nullable();
            $table->decimal('igv')->nullable();
            $table->tinyInteger('status')->nullable();
          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('serial_number');
            $table->dropColumn('subdealership_ruc');
            $table->dropColumn('price_value');
            $table->dropColumn('igv');
            $table->dropColumn('status');
        });
    }
};
