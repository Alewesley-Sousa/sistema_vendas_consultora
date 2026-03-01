<?php
// database/migrations/2024_01_01_000002_create_status_solicitacao_saque_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('status_solicitacao_saque', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 50);
            $table->text('descricao')->nullable();
            $table->timestamps();
        });

        DB::table('status_solicitacao_saque')->insert([
            ['nome' => 'Pendente', 'descricao' => 'Solicitação de saque aguardando aprovação'],
            ['nome' => 'Aprovada', 'descricao' => 'Solicitação de saque aprovada'],
            ['nome' => 'Rejeitada', 'descricao' => 'Solicitação de saque rejeitada'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('status_solicitacao_saque');
    }
};
