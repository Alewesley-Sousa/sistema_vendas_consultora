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
        Schema::create('itens_resgates', function (Blueprint $table) {
            $table->id();
            $table->integer('quantidade')->default(1);
            $table->foreignId('item_catalogo_id')->constrained('itens_catalogo');
            $table->foreignId('resgate_id')->constrained('resgates')->cascadeOnDelete();
            $table->integer('subtotal_pontos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itens_resgates');
    }
};
