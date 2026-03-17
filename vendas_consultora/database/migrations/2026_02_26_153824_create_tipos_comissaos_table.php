<?php
/**
 * Autor: Natha-Barros
 * Data: 01/03/2026
 * Descrição: migration responsavel por criar as características da tabela referente
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tipos_comissao', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 50);
            $table->decimal('taxa', 5, 2)->nullable();
            $table->text('descricao')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tipos_comissao');
    }
};
