<?php

namespace App\Services;

use App\Models\usuarios;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;

class UsuarioService
{
    public function listar() {
        return usuarios::all();
    }

    public function store(array $data): usuarios
    {
        try {
            return DB::transaction(function () use ($data) {
                // Realiza o hash da senha antes de salvar
                $data['senha'] = Hash::make($data['senha']);

                // Cria o registro no banco de dados
                return usuarios::create($data);
            });
        } catch (Exception $e) {
            // Aqui você pode logar o erro se desejar: \Log::error($e->getMessage());
            throw new Exception("Erro ao criar usuário: " . $e->getMessage());
        }
    }

    public function update(int $id, array $data): Usuarios
    {
        try {
            return DB::transaction(function () use ($id, $data) {
                $usuario = Usuarios::findOrFail($id); // <-- Busca no plural

                if (!empty($data['senha'])) {
                    $data['senha'] = Hash::make($data['senha']);
                } else {
                    unset($data['senha']);
                }

                $usuario->update($data);

                return $usuario;
            });
        } catch (Exception $e) {
            throw new Exception("Erro ao atualizar usuário: " . $e->getMessage());
        }
    }

    public function destroy(int $id): bool
    {
        try {
            return DB::transaction(function () use ($id) {
                $usuario = Usuarios::findOrFail($id);
                
                // O método delete() retorna true se conseguir apagar
                return $usuario->delete();
            });
        } catch (Exception $e) {
            throw new Exception("Erro ao excluir usuário: " . $e->getMessage());
        }
    }
}
?>