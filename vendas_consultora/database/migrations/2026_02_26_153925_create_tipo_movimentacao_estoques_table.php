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
        Schema::create('tipo_movimentacao_estoque', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 50);
            $table->text('descricao')->nullable();
            $table->timestamps();
        });

        DB::table('tipo_movimentacao_estoque')->insert([
            ['nome' => 'Entrada', 'descricao' => 'Movimentação de entrada de estoque'],
            ['nome' => 'Saída', 'descricao' => 'Movimentação de saída de estoque'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('tipo_movimentacao_estoque');
    }
};
