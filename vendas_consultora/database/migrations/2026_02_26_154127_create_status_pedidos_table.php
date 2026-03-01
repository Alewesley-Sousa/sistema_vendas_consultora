<?php
// database/migrations/2024_01_01_000016_create_status_pedido_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('status_pedido', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 50);
            $table->text('descricao')->nullable();
            $table->timestamps();
        });

        DB::table('status_pedido')->insert([
            ['nome' => 'Aguardando Pagamento', 'descricao' => 'Pedido aguardando confirmação de pagamento'],
            ['nome' => 'Pagamento Confirmado', 'descricao' => 'Pagamento foi confirmado'],
            ['nome' => 'Separando Pedido', 'descricao' => 'Pedido sendo separado no estoque'],
            ['nome' => 'Pronto para Envio', 'descricao' => 'Pedido pronto para ser enviado'],
            ['nome' => 'Enviado', 'descricao' => 'Pedido foi enviado'],
            ['nome' => 'Entregue', 'descricao' => 'Pedido entregue ao cliente'],
            ['nome' => 'Cancelado', 'descricao' => 'Pedido cancelado'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('status_pedido');
    }
};
