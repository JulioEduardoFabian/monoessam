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
        Schema::table('businesses', function (Blueprint $table) {
            $table->string('ruc')->nullable();
            $table->string('fiscal_address')->nullable();
            $table->string('legal_address')->nullable();
            $table->string('email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->dropColumn('ruc');
            $table->dropColumn('fiscal_address');
            $table->dropColumn('legal_address');
            $table->dropColumn('email');
        });
    }
};
