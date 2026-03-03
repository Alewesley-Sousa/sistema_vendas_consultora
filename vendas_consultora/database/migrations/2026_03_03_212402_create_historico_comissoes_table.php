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
        Schema::create('historico_comissoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultora_id')->constrained('usuarios');
            $table->foreignId('pedido_id')->nullable()->constrained('pedidos');
            $table->foreignId('tipo_comissao_id')->constrained('tipos_comissao');
            $table->decimal('valor', 10, 2)->default(0.0);
            $table->foreignId('tipo_movimentacao_id')->constrained('tipo_movimentacao_comissao');
            $table->timestamp('data_movimentacao')->useCurrent();
            $table->foreignId('usuario_responsavel')->nullable()->constrained('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historico_comissoes');
    }
};
