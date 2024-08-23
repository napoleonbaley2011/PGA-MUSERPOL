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
            $table->integer('number_note'); 
            $table->string('invoice_number'); 
            $table->date('delivery_date')->nullable();
            $table->string('state');
            $table->string('invoice_auth');
            $table->string('user_register');
            $table->string('observation')->nullable();
            $table->foreignId('type_id')->constrained('types')->onDelete('restrict')->onUpdate('cascade');
            $table->unsignedBigInteger('suppliers_id')->nullable(); //id del proveedor
            $table->foreign('suppliers_id')->references('id')->on('suppliers')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name_supplier')->nullable();
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
