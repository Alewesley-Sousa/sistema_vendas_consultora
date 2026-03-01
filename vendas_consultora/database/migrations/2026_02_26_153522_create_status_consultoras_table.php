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
        Schema::create('status_consultoras', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 50);
            $table->text('descricao')->nullable();
            $table->timestamps();
        });

        // Dados iniciais
        DB::table('status_consultoras')->insert([
            ['nome' => 'Ativa', 'descricao' => 'Consultora com vendas válidas no més vigente'],
            ['nome' => 'Inativa', 'descricao' => 'Consultora que não atingiu o minimo de vendas e foi desativada'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('status_consultoras');
    }
};
