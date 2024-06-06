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
        Schema::create('material_requesteds', function (Blueprint $table) {
            $table->id();

            $table->foreignId('material_entries_id')->constrained('material_entries')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('requesteds_id')->constrained('requestds')->onUpdate('cascade')->onDelete('restrict');

            $table->decimal('amount',10,2);
            $table->decimal('amount_delivered',10,2);
            $table->decimal('amounttotal_delivered',10,2);

            $table->integer('invalidate')->nullable();

            $table->decimal('total',10,2)->nullable();
            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_requesteds');
    }
};
