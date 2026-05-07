<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdutoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $produtoId = $this->route('produto');

        return [
            'nome' => 'required|string|max:150|unique:produtos,nome,' . $produtoId,
            'preco' => 'required|numeric|min:0.01|max:999999.99',
            'descricao' => 'nullable|string|max:500',
            'categoria_id' => 'required|integer|exists:categorias,id',
            'status_id' => 'required|integer|exists:status_produtos,id',
            'imagem_url' => 'nullable|url|max:500',
            'estoque_inicial' => 'nullable|integer|min:0'
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O nome do produto é obrigatório.',
            'nome.unique' => 'Já existe um produto com esse nome cadastrado.',
            'preco.required' => 'O preço é obrigatório.',
            'preco.numeric' => 'O preço deve ser um valor numérico.',
            'categoria_id.required' => 'Selecione uma categoria para o produto.',
            'categoria_id.exists' => 'Categoria selecionada não existe.',
            'status_id.required' => 'Selecione um status para o produto.',
            'status_id.exists' => 'Status selecionado não existe.',
        ];
    }
}
