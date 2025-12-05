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
            $table->string('district');
            $table->string('province');
            $table->string('department');
            $table->date('start_date')->nullable();
            $table->tinyInteger('children');
            $table->string('afp')->nullable();
            $table->string('onp')->nullable();
            $table->text('position');
            $table->string('address');
            $table->string('account_number');
            $table->string('system_work');
            $table->string('replacement');
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->foreign('unit_id')->references('id')->on('units')->cascadeOnDelete();
            $table->timestamps();
            $table->double('salary');
            $table->text('observations');
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
