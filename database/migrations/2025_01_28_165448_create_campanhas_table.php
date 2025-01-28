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
        Schema::create('campanhas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('subtitulo')->nullable();
            $table->text('descricao')->nullable();
            $table->enum('status', ['ativo', 'inativo', 'finalizado', 'pendente'])->default('pendente');
            $table->json('galeria')->nullable();
            $table->decimal('valor_cota', 10, 2);
            $table->integer('num_cotas_disponiveis');
            $table->unsignedBigInteger('id_cota_vencedora')->nullable();
            $table->decimal('valor_arrecadado', 10, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campanhas');
    }
};
