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
        Schema::create('qualificacao_profissionals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultora_id')->constrained('usuarios')->cascadeOnDelete();
            $table->timestamp('data_validacao');
            $table->timestamp('data_referencia');
            $table->decimal('total_vendas', 10, 2);
            $table->integer('total_recrutas_ativos');
            $table->enum('status', ['promovido', 'pendente', 'rebaixado', 'mantido']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qualificacao_profissionals');
    }
};
