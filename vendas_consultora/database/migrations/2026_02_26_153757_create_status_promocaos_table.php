<?php
// database/migrations/2024_01_01_000007_create_status_promocao_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('status_promocao', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 50);
            $table->text('descricao')->nullable();
            $table->timestamps();
        });

        DB::table('status_promocao')->insert([
            ['nome' => 'Ativa', 'descricao' => 'Promoção ativa'],
            ['nome' => 'Inativa', 'descricao' => 'Promoção inativa'],
            ['nome' => 'Expirada', 'descricao' => 'Promoção expirada'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('status_promocao');
    }
};
