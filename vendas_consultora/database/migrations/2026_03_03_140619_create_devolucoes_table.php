<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\devolucoes;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('devolucoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos')->cascadeOnDelete();
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->text('motivo')->nullable();
            $table->foreignId('tipo_devolucao_id')->constrained('tipo_devolucao')->nullOnDelete();
            $table->foreignId('status_id')->constrained('status_devolucao')->nullOnDelete();
            $table->timestamp('data_decisao')->nullable();
            $table->timestamp('data_solicitacao')->useCurrent();
            $table->foreignId('usuario_responsavel')->nullable()->constrained('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devolucoes');
    }
};
