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
        Schema::create('requestds', function (Blueprint $table) {
            $table->id();
            $table->string('state',100)->nullable();
            $table->datetime('delivery_date')->nullable();
            $table->string('validate')->nullable();
            $table->string('message',255)->nullable();
            $table->integer('number_note');

            $table->decimal('amount',10,2);
            $table->decimal('total', 10,2);

            $table->foreignId('employees_id')->constrained('public.employees')->onUpdate('cascade')->onDelete('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requestds');
    }
};
