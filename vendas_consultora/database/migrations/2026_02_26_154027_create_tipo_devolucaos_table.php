<?php
// database/migrations/2024_01_01_000013_create_tipo_devolucao_table.php
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
