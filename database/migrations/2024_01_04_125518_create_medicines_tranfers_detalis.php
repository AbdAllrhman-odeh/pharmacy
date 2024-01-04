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
        Schema::create('medicines_tranfers_detalis', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('medicine_transfer_id');
            $table->foreign('medicine_transfer_id')
            ->references('id')
            ->on('medicines_transfer')
            ->onDelete('cascade');

            $table->unsignedBigInteger('medicine_id');
            $table->foreign('medicine_id')
            ->references('id')
            ->on('medicines')
            ->onDelete('cascade');

            $table->unsignedBigInteger('source_pharmacy_id');
            $table->foreign('source_pharmacy_id')
            ->references('id')
            ->on('pharmacies')
            ->onDelete('cascade');

            $table->unsignedBigInteger('destination_pharmacy_id');
            $table->foreign('destination_pharmacy_id')
            ->references('id')
            ->on('pharmacies')
            ->onDelete('cascade');

            $table->integer('quantity')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines_tranfers_detalis');
    }
};
