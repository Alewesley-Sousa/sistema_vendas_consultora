<?php
// database/migrations/2024_01_01_000011_create_tipo_movimentacao_estoque_table.php
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
