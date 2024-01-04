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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('chemical_Name');
            $table->decimal('does')->default('0');
            $table->enum('type',['liquid','tablet','cream']);
            $table->decimal('quantity')->default('0');
            $table->decimal('price')->default('0');
            $table->date('exp_date');
            $table->date('mfg_date');
            
            $table->unsignedBigInteger('pharmacy_id');
            $table->foreign('pharmacy_id')
            ->references('id')
            ->on('pharmacies')
            ->onDelete('cascade');

            $table->string('compnay_name')->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
