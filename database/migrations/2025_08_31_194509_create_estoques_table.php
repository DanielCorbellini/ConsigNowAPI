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
        Schema::create('estoques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('almoxarifado_id')->constrained('almoxarifados');
            $table->foreignId('produto_id')->constrained('produtos');
            $table->integer('quantidade')->default(0);
            $table->timestamps();

            //Não pode existir duas linhas para o mesmo produto no mesmo almoxarifado
            $table->unique(['almoxarifado_id', 'produto_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estoques');
    }
};
