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
       Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('bem_locavel_id');
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->decimal('preco_total', 10, 2)->nullable();
            $table->enum('status', ['reservado', 'cancelado'])->default('reservado');
            $table->timestamps();

            // Definição da chave estrangeira para bem_locavel_id
            $table->foreign('bem_locavel_id')->references('id')->on('bens_locaveis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
