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
            $table->integer('number_note')->nullable();
            $table->string('state');
            $table->string('observation')->nullable();
            $table->string('observation_request')->nullable();
            $table->foreignId('user_register')->constrained('public.employees')->onDelete('restrict')->onUpdate('cascade');
            $table->date('request_date');
            $table->date('received_on_date')->nullable();
            $table->foreignId('type_id')->constrained('types')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('management_id')->constrained('management')->onDelete('restrict')->onUpdate('cascade');
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
