<?php
// database/migrations/2024_01_01_000006_create_status_devolucao_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('status_devolucao', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 50);
            $table->text('descricao')->nullable();
            $table->timestamps();
        });

        DB::table('status_devolucao')->insert([
            ['nome' => 'Pendente', 'descricao' => 'Devolução aguardando análise'],
            ['nome' => 'Aprovada', 'descricao' => 'Devolução aprovada'],
            ['nome' => 'Rejeitada', 'descricao' => 'Devolução rejeitada'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('status_devolucao');
    }
};
