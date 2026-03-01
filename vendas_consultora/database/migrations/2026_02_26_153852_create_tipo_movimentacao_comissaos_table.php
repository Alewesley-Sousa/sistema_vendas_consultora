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
        Schema::create('tipo_movimentacao_comissao', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 50);
            $table->text('descricao')->nullable();
            $table->timestamps();
        });

        DB::table('tipo_movimentacao_comissao')->insert([
            ['nome' => 'venda', 'descricao' => 'Movimentação de comissão gerada por venda'],
            ['nome' => 'estorno', 'descricao' => 'Movimentação de comissão gerada por estorno de venda, se a comissão ja tiver sido sacada, o valor do estorno será descontado do próximo saque'],
            ['nome' => 'saque', 'descricao' => 'Movimentação de comissão gerada por solicitação de saque'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('tipo_movimentacao_comissao');
    }
};
