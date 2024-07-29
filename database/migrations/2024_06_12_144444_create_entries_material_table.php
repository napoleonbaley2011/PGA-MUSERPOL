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
        Schema::create('entries_material', function (Blueprint $table) {
            $table->id();
            $table->foreignId('note_id')->constrained('note_entries')->onDelete('cascade');
            $table->foreignId('material_id')->constrained()->onDelete('cascade');
            $table->integer('amount_entries')->nullable();
            $table->integer('request')->nullable();
            $table->double('cost_unit', 2, 8)->nullable();
            $table->decimal('cost_total', 10, 2)->default(0.00)->nullable();
            $table->string('name_material')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entries_material');
    }
};
