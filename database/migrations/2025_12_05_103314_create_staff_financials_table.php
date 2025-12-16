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
        Schema::create('staff_financials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id')->nullable();
            $table->foreign('staff_id')->references('id')->on('staff')->cascadeOnDelete();
            $table->string('district')->nullable();
            $table->string('province')->nullable();
            $table->string('department')->nullable();
            $table->date('start_date')->nullable();
            $table->tinyInteger('children')->nullable();
            $table->string('afp')->nullable();
            $table->string('onp')->nullable();
            $table->string('address')->nullable();
            $table->string('account_number')->nullable();
            $table->string('system_work')->nullable();
            $table->string('replacement')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->foreign('unit_id')->references('id')->on('units')->cascadeOnDelete();
            $table->double('salary')->nullable();
            $table->text('observations')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_financials');
    }
};
