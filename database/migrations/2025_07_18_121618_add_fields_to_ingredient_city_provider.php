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
        Schema::table('ingredient_city_provider', function (Blueprint $table) {
            $table->unsignedBigInteger('measurement_unit_id')->nullable()->after('ingredient_id');
            $table->foreign('measurement_unit_id')->references('id')->on('measurement_units')->nullOnDelete();
            $table->string('presentation')->nullable()->after('measurement_unit_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ingredient_city_provider', function (Blueprint $table) {
        $table->dropForeign(['measurement_unit_id']);
        $table->dropColumn('measurement_unit_id');
        $table->dropColumn('presentation');
    });
    }
};
