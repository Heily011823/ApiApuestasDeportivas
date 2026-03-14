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
        Schema::create('bets', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id'); // usuario que apuesta
            $table->decimal('amount',10,2); // dinero apostado
            $table->decimal('odds',5,2); // cuota
            $table->decimal('potential_win',10,2); // posible ganancia
            $table->string('status')->default('pending'); // estado

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bets');
    }
};