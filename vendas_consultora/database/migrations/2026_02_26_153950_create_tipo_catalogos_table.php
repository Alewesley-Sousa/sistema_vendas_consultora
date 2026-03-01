<?php
// database/migrations/2024_01_01_000012_create_tipo_catalogo_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tipo_catalogo', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 50);
            $table->text('descricao')->nullable();
            $table->timestamps();
        });

        DB::table('tipo_catalogo')->insert([
            ['nome' => 'recompensas', 'descricao' => 'Catálogo de recompensas para resgate de pontos'],
            ['nome' => 'vendas', 'descricao' => 'Catálogo de produtos disponíveis para venda'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('tipo_catalogo');
    }
};

