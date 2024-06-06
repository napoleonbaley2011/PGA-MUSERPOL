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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('code_material');
            $table->string('description');
            $table->string('unit_material');
            $table->string('state');
            $table->integer('amount')->nullable();
            $table->integer('min');
            $table->string('barcode')->nullable();
            $table->integer('total');
            $table->foreignId('group_id')->constrained('groups')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
