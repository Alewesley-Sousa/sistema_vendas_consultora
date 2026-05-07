<?php
/**
 * REFERÊNCIA DE MIGRATIONS NECESSÁRIAS
 * 
 * Estas são as tabelas que devem estar no banco de dados para o sistema funcionar
 * Se já existem, você pode pular. Se não, crie as migrations abaixo.
 * 
 * Para criar uma nova migration, execute:
 * php artisan make:migration create_nome_tabela_table
 * 
 * Ou copie o conteúdo abaixo e crie a migration manualmente
 */

// ============================================================================
// MIGRATION 1: Criar tabela 'categorias' (se não existir)
// ============================================================================

// Arquivo: database/migrations/XXXX_XX_XX_XXXXXX_create_categorias_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriasTable extends Migration
{
    public function up()
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100)->unique();
            $table->string('descricao', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('categorias');
    }
}

// ============================================================================
// MIGRATION 2: Criar tabela 'status_produtos' (se não existir)
// ============================================================================

// Arquivo: database/migrations/XXXX_XX_XX_XXXXXX_create_status_produtos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusProdutosTable extends Migration
{
    public function up()
    {
        Schema::create('status_produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 50)->unique(); // Ex: "Ativo", "Inativo", "Descontinuado"
            $table->string('descricao', 255)->nullable();
            $table->timestamps();
        });

        // Inserir status padrão
        DB::table('status_produtos')->insert([
            ['nome' => 'Ativo', 'descricao' => 'Produto disponível para venda'],
            ['nome' => 'Inativo', 'descricao' => 'Produto temporariamente indisponível'],
            ['nome' => 'Descontinuado', 'descricao' => 'Produto descontinuado'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('status_produtos');
    }
}

// ============================================================================
// MIGRATION 3: Modificar/Criar tabela 'produtos'
// ============================================================================

// Arquivo: database/migrations/XXXX_XX_XX_XXXXXX_create_produtos_table.php
// OU database/migrations/XXXX_XX_XX_XXXXXX_modify_produtos_table.php (se já existe)

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutosTable extends Migration
{
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 150)->unique();
            $table->decimal('preco', 10, 2);
            $table->text('descricao')->nullable();
            
            // Relacionamentos
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->foreignId('status_id')->constrained('status_produtos')->onDelete('restrict');
            
            // Adicional
            $table->string('imagem_url', 500)->nullable();
            $table->timestamps();
            $table->softDeletes(); // Para soft delete
        });
    }

    public function down()
    {
        Schema::dropIfExists('produtos');
    }
}

// ============================================================================
// MIGRATION 4: Criar tabela 'estoques'
// ============================================================================

// Arquivo: database/migrations/XXXX_XX_XX_XXXXXX_create_estoques_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstoquesTable extends Migration
{
    public function up()
    {
        Schema::create('estoques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produto_id')->constrained('produtos')->onDelete('cascade');
            $table->integer('quantidade')->default(0);
            $table->string('localizacao', 100)->nullable();
            $table->string('lote', 50)->nullable();
            $table->timestamps();

            // Índice para performance
            $table->index('produto_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('estoques');
    }
}

// ============================================================================
// PASSO A PASSO PARA EXECUTAR
// ============================================================================

/*
1. Copie cada migration para o arquivo correspondente em database/migrations/

2. Execute todas as migrations:
   php artisan migrate

3. Se precisar desfazer:
   php artisan migrate:rollback

4. Para verificar o status:
   php artisan migrate:status

5. Insira dados de teste (OPCIONAL):
   php artisan tinker
   
   // Dentro do tinker:
   App\Models\categorias::create(['nome' => 'Cosméticos', 'descricao' => 'Produtos de beleza']);
   App\Models\categorias::create(['nome' => 'Perfumaria', 'descricao' => 'Perfumes e desodorizantes']);
   
   // Para verificar:
   App\Models\categorias::all();

6. Teste a API:
   curl -X GET http://seu-dominio.com/api/produtos \
   -H "Accept: application/json" \
   -H "X-CSRF-TOKEN: seu-token"
*/

// ============================================================================
// TROUBLESHOOTING
// ============================================================================

/*
ERRO: "SQLSTATE[HY000]: General error: 1030 Got error 28"
- Significa que o disco está cheio. Libere espaço.

ERRO: "Undefined table: 'categorias'"
- A migration de categorias não foi executada. Execute: php artisan migrate

ERRO: "Column not found"
- A coluna esperada não existe. Verifique as migrations.
- Execute: php artisan migrate:fresh (⚠️ Apaga todos os dados!)

ERRO: "Foreign key constraint failed"
- Você tentou deletar uma categoria/status que tem produtos.
- Delete os produtos primeiro ou use onDelete('cascade').
*/

?>
