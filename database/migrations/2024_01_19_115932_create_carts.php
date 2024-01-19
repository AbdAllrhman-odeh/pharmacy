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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('pharamcy_id');
            $table->foreign('pharmacy_id')
            ->references('id')
            ->on('pharmacies')
            ->onDelete('cascade');

            $table->unsignedBigInteger('cashier_id');
            $table->foreign('cashier_id')
            ->references('id')
            ->on('cashiers')
            ->onDelete('cascade');

            $table->unsignedBigInteger('medicine_id');
            $table->foreign('medicine_id')
            ->references('id')
            ->on('medicines')
            ->onDelete('cascade');

            $table->integer('quantity');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
