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
            $table->integer('stock')->nullable();
            $table->decimal('average_cost', 10, 2)->default(0.00)->nullable();
            $table->integer('min')->nullable();
            $table->string('barcode')->nullable();
            $table->enum('type', ['Caja Chica', 'Almacen', 'Fondo de Avance']);
            $table->foreignId('group_id')->constrained('groups')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
            $table->softDeletes();
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
