<?php
// database/migrations/2024_01_01_000005_create_status_item_catalogo_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('status_item_catalogos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 50);
            $table->text('descricao')->nullable();
            $table->timestamps();
        });

        DB::table('status_item_catalogos')->insert([
            ['nome' => 'Disponível', 'descricao' => 'Item disponível para compra'],
            ['nome' => 'Indisponível', 'descricao' => 'Item indisponível para compra'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('status_item_catalogos');
    }
};
