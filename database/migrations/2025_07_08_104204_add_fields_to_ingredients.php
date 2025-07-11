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
        Schema::table('ingredients', function (Blueprint $table) {
        $table->unsignedBigInteger('measurement_unit_id')->nullable();
        $table->foreign('measurement_unit_id')->references('id')->on('measurement_units')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ingredients', function (Blueprint $table) {
        $table->dropForeign(['measurement_unit_id']);
        $table->dropColumn('measurement_unit_id');
        });
    }
};


