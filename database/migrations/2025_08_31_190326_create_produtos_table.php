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
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_interno')->unique();
            $table->string('descricao');
            $table->foreignId('catregoria_id')->constrained('categorias');
            $table->decimal('preco_custo', 10, 2);
            $table->decimal('preco_venda', 10, 2);
            $table->string('tamanho', 10)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
