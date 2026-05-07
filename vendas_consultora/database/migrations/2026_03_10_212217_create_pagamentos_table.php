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
        Schema::create('pagamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos')->cascadeOnDelete();
            $table->enum('tipo_pagamento',['credito', 'debito', 'pix']);
            $table->decimal('valor', 10, 2);
            $table->enum('status', ['pendente', 'recusado', 'aprovado', 'estornado', 'em_analise']);
            $table->string('codigo_transacao', 100);
            $table->timestamp('data_solicitacao')->useCurrent();
            $table->timestamp('data_confirmacao')->nullable();
            $table->foreignId('usuario_responsavel')->nullable()->constrained('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagamentos');
    }
};
