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
        Schema::create('note_entries', function (Blueprint $table) {
            $table->id();
            $table->integer('number_note');//numero de nota
            $table->string('invoice_number');//numero de factura
            $table->datetime('delivery_date')->nullable();//fecha de ingreso
            $table->string('state');
            $table->string('invoice_auth');
            $table->string('user_register');
            $table->string('observation')->nullable();
            //$table->integer('amount_articles');
            $table->foreignId('type_id')->constrained('types')->onDelete('restrict')->onUpdate('cascade');
            $table->unsignedBigInteger('suppliers_id')->nullable();//id del proveedor
            $table->foreign('suppliers_id')->references('id')->on('suppliers')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('note_entries');
    }
};
