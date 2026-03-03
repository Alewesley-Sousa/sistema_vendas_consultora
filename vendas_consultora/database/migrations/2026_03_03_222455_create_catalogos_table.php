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
        Schema::create('catalogos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->foreignId('tipo_catalogo_id')->constrained('tipo_catalogo');
            $table->foreignId('status_id')->constrained('status_catalogo');
            $table->text('descricao')->nullable();
            $table->timestamp('data_encerramento');
            $table->timestamp('data_publicacao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalogos');
    }
};
