<?php
// database/migrations/2024_01_01_000008_create_status_meta_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('status_metas', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 50);
            $table->text('descricao')->nullable();
            $table->timestamps();
        });

        DB::table('status_metas')->insert([
            ['nome' => 'Atingida', 'descricao' => 'Meta foi atingida'],
            ['nome' => 'Não atingida', 'descricao' => 'Meta não foi atingida'],
            ['nome' => 'Ativa', 'descricao' => 'Meta está ativa'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('status_metas');
    }
};
