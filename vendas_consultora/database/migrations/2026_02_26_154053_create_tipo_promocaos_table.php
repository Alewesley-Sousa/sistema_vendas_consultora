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
        Schema::create('tipo_promocao', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 50);
            $table->text('descricao')->nullable();
            $table->timestamps();
        });

        DB::table('tipo_promocao')->insert([
            ['nome' => 'desconto percentual', 'descricao' => 'Promoção que oferece um desconto percentual sobre o preço do produto'],
            ['nome' => 'desconto fixo', 'descricao' => 'Promoção que oferece um desconto fixo em reais sobre o preço do produto'],
            ['nome' => 'brinde', 'descricao' => 'Promoção que oferece um brinde na compra do produto'],
            ['nome' => 'frete grátis', 'descricao' => 'Promoção que oferece frete grátis na compra do produto'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('tipo_promocao');
    }
};
