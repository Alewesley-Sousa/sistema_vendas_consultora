<?php 
namespace App\Services;

use App\Models\catalogos;
use App\Models\itens_catalogo;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CatalogoService {

    // Catalogos
    public function trazerCatalogos($busca = null) {
        try {
            $query = catalogos::where('status_id', 1);

            if ($busca) {
                $query->where(function($q) use ($busca) {
                    $q->where('nome', 'like', "%{$busca}%")
                    ->orWhere('descricao', 'like', "%{$busca}%");
                });
            }

            $catalogos = $query->paginate(8);

            return [
                'status' => 'success',
                'data' => $catalogos
            ];
        } catch (Exception $e) {
            return ['status' => 'error', 'mensagem' => $e->getMessage()];
        }
    }

    // Itens do Catálogo
    public function trazerItens($id, $busca = null) {
        try {
            $query = itens_catalogo::with('produto')
                ->where('catalogo_id', $id);

            if ($busca) {
                $query->whereHas('produto', function($q) use ($busca) {
                    $q->where('nome', 'like', "%{$busca}%");
                });
            }

            $itens = $query->paginate(6);

            return [
                'status' => 'success',
                'data' => $itens
            ];
        } catch (Exception $e) {
            return ['status' => 'error', 'mensagem' => $e->getMessage()];
        }
    }
}