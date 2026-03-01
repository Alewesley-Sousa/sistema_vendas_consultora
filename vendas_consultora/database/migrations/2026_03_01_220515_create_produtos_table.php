<?php
/**
 * Autor: Alewesley-Sousa
 * Data: 01/03/2026
 * Descrição: migration responsavel por criar as características da tabela referente
 */

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
            $table->string('nome', 150);
            $table->decimal('preco', 10, 2)->default(0.0);
            $table->text('descricao');
            $table->string('imagem_url');
            $table->foreignId('categoria_id')->nullable()->constrained('categorias')->nullOnDelete();
            $table->foreignId('status_id')->nullable()->constrained('status_produto')->nullOnDelete();
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
