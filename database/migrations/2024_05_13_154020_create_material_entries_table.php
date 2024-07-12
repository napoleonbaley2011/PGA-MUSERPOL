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
        // Schema::create('material_entries', function (Blueprint $table) {
        //     $table->id();
        //     $table->decimal('amount',10,2)->default(0.00)->nullable();
        //     $table->decimal('cost',10,2)->default(0.00)->nullable();
        //     $table->integer('subtotal')->nullable();
        //     $table->dateTime('entrydate')->nullable();
        //     $table->foreignId('material_id')->constrained('materials')->onUpdate('cascade')->onDelete('restrict');
        //     $table->integer('integer');
        //     $table->foreignId('entries_id')->constrained('entries')->onUpdate('cascade')->onDelete('restrict');
        //     $table->string('invalidate')->nullable();
        //     $table->string('state')->nullable();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_entries');
    }
};
