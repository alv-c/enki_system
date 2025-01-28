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
        Schema::create('campanha_planos_promocao', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campanha_id')->constrained('campanhas')->onDelete('cascade');
            $table->integer('num_rifas');
            $table->decimal('valor_plano', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campanha_planos_promocao');
    }
};
