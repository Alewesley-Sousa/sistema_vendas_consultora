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
        Schema::create('promocoes', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100)->nullable();
            $table->decimal('desconto', 10, 2)->default(null);
            $table->text('descricao')->nullable();
            $table->foreignId('tipo_promocao_id')->constrained('tipo_promocao');
            $table->timestamp('data_inicio');
            $table->timestamp('data_fim');
            $table->foreignId('status_id')->constrained('status_promocao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promocoes');
    }
};
