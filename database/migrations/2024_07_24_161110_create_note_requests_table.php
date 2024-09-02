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
        Schema::create('note_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('number_note');
            $table->string('state');
            $table->string('observation')->nullable();
            $table->foreignId('user_register')->constrained('public.employees')->onDelete('restrict')->onUpdate('cascade');
            $table->date('request_date');
            $table->date('received_on_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('note_requests');
    }
};
