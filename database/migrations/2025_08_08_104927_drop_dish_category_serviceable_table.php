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
         Schema::dropIfExists('dish_category_serviceable');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::create('dish_category_serviceable', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dish_category_id')->nullable();
            $table->foreign('dish_category_id')->references('id')->on('dish_categories')->onDelete('cascade');
            $table->unsignedBigInteger('serviceable_id')->nullable();
            $table->foreign('serviceable_id')->references('id')->on('serviceables')->onDelete('cascade');
            $table->decimal('volume', 10, 2)->nullable();
            $table->integer('protion_percentaje')->nullable();
            $table->decimal('lower_limit', 10, 2)->nullable();
            $table->decimal('upper_limit', 10, 2)->nullable();
            $table->decimal('cost', 10, 2)->nullable();
            $table->timestamps();
        });
    }
};
