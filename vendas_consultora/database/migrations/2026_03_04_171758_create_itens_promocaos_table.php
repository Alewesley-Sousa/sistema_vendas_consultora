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
        Schema::create('itens_promocao', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produto_id')->constrained('produtos')->cascadeOnDelete();
            $table->foreignId('promocao_id')->constrained('promocoes')->cascadeOnDelete();

            // Novo: Agora cada produto tem seu próprio tipo e valor de desconto
            $table->foreignId('tipo_promocao_id')->constrained('tipo_promocao');
            $table->decimal('valor_desconto', 10, 2)->default(0);

            $table->integer('quantidade_min')->default(1);
            $table->foreignId('status_id')->constrained('status_promocao'); // Controle individual
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itens_promocaos');
    }
};
