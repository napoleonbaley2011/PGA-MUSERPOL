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
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->datetime('entry_date')->nullable(); //fecha de ingreso del material
            $table->string('invoice_number',255)->nullable();
            $table->datetime('invoice_data')->nullable();
            $table->unsignedBigInteger('suppliers_id')->nullable();
            $table->foreign('suppliers_id')->references('id')->on('suppliers')->onUpdate('cascade')->onDelete('restrict');
            $table->decimal('total',10,2)->default(0.00);
            $table->foreignId('employees_id')->constrained('public.employees')->nullable()->onUpdate('cascade')->onDelete('restrict'); //Sea almacena el id de la persona que recepciona o maneja el so
            $table->datetime('entry_date_create')->nullable();
            $table->integer('invalidate')->nullable();
            $table->string('message',255)->nullable();
            $table->string('invoice_authorization',255)->nullable();
            $table->integer('note_number')->nullable();
            $table->decimal('subtotal',10,2)->default(0.00)->nullable();
            $table->decimal('discount',10,2)->default(0.00)->nullable();
            $table->string('increase')->nullable();
            $table->string('observation')->nullable();
            $table->decimal('amount',10,2)->default(0.00)->nullable();
            $table->string('state')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entries');
    }
};
