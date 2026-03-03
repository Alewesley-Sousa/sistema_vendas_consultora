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
        Schema::create('solicitacoes_saques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultora_id')->constrained('usuarios')->cascadeOnDelete();
            $table->decimal('valor_solicitado', 10, 2)->default(1.0);
            $table->foreignId('status_id')->constrained('status_solicitacao_saque');
            $table->timestamp('data_decisao')->nullable();
            $table->timestamp('data_solicitacao')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitacoes_saques');
    }
};
