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
        Schema::create('tipo_devolucao', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 50);
            $table->text('descricao')->nullable();
            $table->timestamps();
        });

        DB::table('tipo_devolucao')->insert([
            ['nome' => 'parcial', 'descricao' => 'Devolução parcial do pedido, onde apenas alguns itens são devolvidos'],
            ['nome' => 'total', 'descricao' => 'Devolução total do pedido, onde todos os itens são devolvidos'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('tipo_devolucao');
    }
};
