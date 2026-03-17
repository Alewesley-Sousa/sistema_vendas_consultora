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
        Schema::create('itens_catalogo', function (Blueprint $table) {
            $table->id();
            $table->decimal('preco', 10, 2)->nullable();
            $table->integer('pontos_necessarios')->nullable();
            $table->foreignId('status_id')->constrained('status_item_catalogo');
            $table->integer('estoque_disponivel')->default(1);
            $table->foreignId('produto_id')->constrained('produtos')->cascadeOnDelete();
            $table->foreignId('catalogo_id')->constrained('catalogos')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itens_catalogos');
    }
};
