<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\comissoes;
use App\Models\usuarios;

class ComissoesSeeder extends Seeder
{
    public function run(): void
    {
        // Lista de saldos que queremos atribuir
        $saldosDesejados = [
            1  => 250.75,
            2  => 1250.50, // João Pereira
            21 => 420.80,
            22 => 310.20,
            23 => 195.00,
            24 => 285.60,
            26 => 98.45,
            7  => 149.69, // O ID que está dando erro
        ];

        foreach ($saldosDesejados as $id => $saldo) {
            // SÓ CRIA SE O USUÁRIO EXISTIR
            if (usuarios::where('id', $id)->exists()) {
                comissoes::updateOrCreate(
                    ['consultora_id' => $id],
                    ['saldo_liquido' => $saldo]
                );
            }
        }

        // OPCIONAL: Criar um saldo aleatório para qualquer outro usuário que sobrou e não tem comissão
        $usuariosSemComissao = usuarios::whereDoesntHave('comissao')->get();
        foreach ($usuariosSemComissao as $user) {
            comissoes::create([
                'consultora_id' => $user->id,
                'saldo_liquido' => rand(50, 300) + (rand(0, 99) / 100)
            ]);
        }
    }
}
