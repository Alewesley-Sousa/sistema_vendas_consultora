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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nome',100);
            $table->enum('cargo', ['consultora', 'lider', 'distribuidora'])->default('consultora');
            $table->string('email',150)->unique();
            $table->string('telefone',20)->nullable();
            $table->varchar('senha');
            $table->string('cep',10);
            $table->foreignId('consultora_id')->constrained('usuarios')->nullOnDelete();
            $table->foreignId('status_id')->constrained('status_consultoras');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
