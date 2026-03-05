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
        Schema::create('metas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultora_id')->constrained('usuarios')->cascadeOnDelete();
            $table->foreignId('lider_id')->constrained('usuarios')->cascadeOnDelete();
            $table->decimal('valor_meta', 10, 2)->default(0.0);
            $table->timestamp('data_referencia');
            $table->foreignId('status_id')->constrained('status_meta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metas');
    }
};
