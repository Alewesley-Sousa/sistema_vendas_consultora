<?php
/**
 * Autor: Alewesley-Sousa
 * Data: 01/03/2026
 * Descrição: Controller responsável por controlar entrada e saída de dados de categorias
 */

namespace App\Http\Controllers;

use App\Models\categorias; // Lembrar de checar se o Model segue o plural "categorias"
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriasController extends Controller
{
    /**
     * Listar todas as categorias.
     */
    public function index()
    {
        try {
            // Se o seu Model não usar timestamps, o all() funciona perfeitamente
            $categorias = categorias::all();
            
            return response()->json([
                'status' => 'success',
                'data' => $categorias
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'mensagem' => 'Erro ao listar categorias: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Criar uma nova categoria.
     */
    public function store(Request $request)
    {
        // Validação dos campos baseados na sua migration
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:100',
            'descricao' => 'required|string'
        ], [
            'nome.required' => 'O nome da categoria é obrigatório.',
            'nome.max' => 'O nome da categoria não pode passar de 100 caracteres.',
            'descricao.required' => 'A descrição da categoria é obrigatória.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Criando o registro no banco
            $categoria = categorias::create([
                'nome' => trim($request->nome),
                'descricao' => trim($request->descricao)
            ]);

            return response()->json([
                'status' => 'success',
                'mensagem' => 'Categoria criada com sucesso!',
                'data' => $categoria
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'mensagem' => 'Não foi possível salvar a categoria: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remover uma categoria específica do banco de dados.
     */
    public function destroy($id)
    {
        try {
            $categoria = categorias::find($id);

            if (!$categoria) {
                return response()->json([
                    'status' => 'error',
                    'mensagem' => 'Categoria não encontrada.'
                ], 404);
            }

            // Deleta a categoria
            $categoria->delete();

            return response()->json([
                'status' => 'success',
                'mensagem' => 'Categoria excluída com sucesso!'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'mensagem' => 'Erro ao excluir categoria: ' . $e->getMessage()
            ], 500);
        }
    }
}