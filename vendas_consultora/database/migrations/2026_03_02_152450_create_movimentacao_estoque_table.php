<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\movimentacao_estoque;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movimentacao_estoque', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produto_id')->constrained('produtos')->cascadeOnDelete();
            $table->integer('quantidade');
            $table->string('origem_tipo', 50)->nullable();
            $table->integer('origem_id')->nullable();
            $table->foreignId('tipo_movimentacao_id')->nullable()->constrained('tipo_movimentacao_estoque')->nullOnDelete(); // TIRAR NULLABLE
            $table->foreignId('usuario_responsavel')->nullable()->constrained('usuarios')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimentacao_estoques');
    }
};
