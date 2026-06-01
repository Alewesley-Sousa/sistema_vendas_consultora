<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('catalogos', function (Blueprint $table) {
            $table->timestamp('data_publicacao')->nullable()->change();
            $table->timestamp('data_encerramento')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('catalogos', function (Blueprint $table) {
            $table->timestamp('data_publicacao')->nullable(false)->change();
            $table->timestamp('data_encerramento')->nullable(false)->change();
        });
    }
};
