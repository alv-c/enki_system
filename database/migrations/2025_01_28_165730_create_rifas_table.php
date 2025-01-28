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
        Schema::create('rifas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_campanha')->constrained('campanhas')->onDelete('cascade');
            $table->unsignedBigInteger('numero')->unique(); // Tornar o número único
            $table->foreignId('id_comprador')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('status', ['disponivel', 'reservada', 'vendida'])->default('disponivel');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rifas');
    }
};
