<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\pedidos;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('usuario_id')->constrained('usuarios');
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->string('link')->nullable();
            $table->foreignId('status_id')->constrained('status_pedido');
            $table->decimal('valor_total', 10, 2)->default(0.0);
            $table->enum('tipo_pagamento', ['credito', 'debito', 'pix']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
