<?php
// database/migrations/2024_01_01_000015_create_status_produto_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('status_produto', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 50);
            $table->text('descricao')->nullable();
            $table->timestamps();
        });

        DB::table('status_produto')->insert([
            ['nome' => 'Ativo', 'descricao' => 'Produto ativo e disponível para venda'],
            ['nome' => 'Inativo', 'descricao' => 'Produto inativo'],
            ['nome' => 'Descontinuado', 'descricao' => 'Produto descontinuado'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('status_produto');
    }
};
