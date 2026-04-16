<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdutosRequest extends FormRequest
{
    /**
     * Determina se o usuário está autorizado a fazer este request.
     */
    public function authorize(): bool
    {
        // Como você está usando o middleware 'auth:sanctum', 
        // podemos retornar true aqui.
        return true;
    }

    /**
     * Regras de validação aplicadas ao request.
     */
    public function rules(): array
    {
        // Lógica para diferenciar regras de POST (store) e PUT (update)
        $isUpdate = $this->isMethod('put') || $this->isMethod('patch');

        return [
            'nome' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:150'
            ],
            'preco' => [
                $isUpdate ? 'sometimes' : 'required',
                'numeric',
                'min:0'
            ],
            'descricao' => [
                $isUpdate ? 'sometimes' : 'required',
                'string'
            ],
            'imagem_url' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'url' // Garante que seja um link válido
            ],
            'categoria_id' => [
                'nullable',
                'exists:categorias,id' // Valida se a categoria realmente existe na tabela
            ],
        ];
    }

    /**
     * Mensagens personalizadas de erro (Opcional)
     */
    public function messages(): array
    {
        return [
            'nome.required' => 'O nome do produto é obrigatório.',
            'preco.numeric' => 'O preço deve ser um valor numérico.',
            'categoria_id.exists' => 'A categoria selecionada não existe.',
            'imagem_url.url' => 'O formato da URL da imagem é inválido.',
        ];
    }
}
