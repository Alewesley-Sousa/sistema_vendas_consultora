<?php
// database/migrations/2024_01_01_000004_create_status_catalogo_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('status_catalogo', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 50);
            $table->text('descricao')->nullable();
            $table->timestamps();
        });

        DB::table('status_catalogo')->insert([
            ['nome' => 'Ativo', 'descricao' => 'Catálogo ativo e disponível'],
            ['nome' => 'Inativo', 'descricao' => 'Catálogo inativo e indisponível'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('status_catalogo');
    }
};
