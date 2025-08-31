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
        Schema::create('condicional_itens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('condicional_id')->constrained('condicionais');
            $table->foreignId('produto_id')->constrained('produtos');
            $table->integer('quantidade_entregue');
            $table->integer('quantidade_devolvida')->default(0);
            $table->integer('quantidade_vendida')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('condicionais_itens');
    }
};
