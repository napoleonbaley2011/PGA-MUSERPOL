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
        Schema::create('petty_cashes', function (Blueprint $table) {
            $table->id();
            $table->integer('number_note');
            $table->text('concept');
            $table->date('request_date');
            $table->date('delivery_date')->nullable();
            $table->text('comment_recived')->nullable();
            $table->decimal('approximate_cost', 10, 2)->nullable();
            $table->decimal('replacement_cost', 10, 2)->nullable();
            $table->string('state');
            $table->foreignId('user_register')->constrained('public.employees')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('petty_cashes');
    }
};
