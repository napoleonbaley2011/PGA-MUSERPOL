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
        Schema::create('user_rol_stores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('user_stores')->onDelete('cascade');
            $table->foreignId('rol_id')->constrained('rol_stores')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_rol_stores');
    }
};
