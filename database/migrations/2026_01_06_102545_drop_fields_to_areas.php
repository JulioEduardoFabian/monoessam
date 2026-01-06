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
        Schema::table('areas', function (Blueprint $table) {
        $table->dropForeign(['headquarter_id']);
        $table->dropColumn('headquarter_id');
        $table->dropForeign(['cafe_id']);
        $table->dropColumn('cafe_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('areas', function (Blueprint $table) {
            $table->unsignedBigInteger('headquarter_id')->nullable();
            $table->foreign('headquarter_id')->references('id')->on('headquarters')->nullOnDelete();
            $table->unsignedBigInteger('cafe_id')->nullable();
            $table->foreign('cafe_id')->references('id')->on('cafes')->nullOnDelete();
        });
    }
};
