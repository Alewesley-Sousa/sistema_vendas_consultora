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
        Schema::create('historico_cargo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultora_id')->constrained('usuarios')->cascadeOnDelete();
            $table->foreignId('qualificacao_profissional_id')->constrained('qualificacao_profissional')->cascadeOnDelete();
            $table->enum('cargo_anterior', ['consultora', 'lider', 'distribuidora']);
            $table->enum('cargo_novo', ['consultora', 'lider', 'distribuidora']);
            $table->timestamp('data_mudanca')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historico_cargos');
    }
};
