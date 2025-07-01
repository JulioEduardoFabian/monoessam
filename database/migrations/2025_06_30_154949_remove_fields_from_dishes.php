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
        Schema::table('dishes', function (Blueprint $table) {
            $table->dropForeign(['dish_category_id']);
            $table->dropColumn('dish_category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dishes', function (Blueprint $table) {
        $table->unsignedBigInteger('dish_category_id')->nullable();
        $table->foreign('dish_category_id')->references('id')->on('dish_categories')->nullOnDelete();    
        });
    }
};
