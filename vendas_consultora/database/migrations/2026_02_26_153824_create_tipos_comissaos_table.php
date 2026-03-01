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
            $table->timestamps();
        });

        DB::table('tipos_comissao')->insert([
            ['nome' => 'Venda Direta', 'descricao' => 'Comissão gerada por venda direta da consultora', 'taxa' => 0.30],
            ['nome' => 'nivel 1', 'descricao' => 'Comissão gerada por venda da rede direta (1º nível)', 'taxa' => 0.05],
            ['nome' => 'nivel 2', 'descricao' => 'Comissão gerada por venda da rede da sua rede (2º nível)', 'taxa' => 0.02],
            ['nome' => 'administrativa', 'descricao' => 'taxa administrativa sobre cada venda', 'taxa' => 0.02],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('tipos_comissao');
    }
};
