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
        $isUpdate = $this->isMethod('put') || $this->isMethod('patch') || $this->has('_method');

        return [
            'nome' => 'required|string|max:150|unique:produtos,nome,' . $produtoId,
            
            // Aceita tanto formato numérico puro quanto string vinda do input (convertendo a vírgula antes se necessário no Controller)
            'preco' => 'required|numeric|min:0.01|max:999999.99',
            
            'descricao' => 'nullable|string|max:500',
            'categoria_id' => 'required|integer|exists:categorias,id',
            
            // Ajustado para validar o status em string ('ativo'/'inativo') enviado pelo Alpine
            'status' => 'required|string|in:ativo,inativo',
            
            // Validação da imagem: obrigatória na criação, opcional na edição (mimes e max size seguros)
            'imagem' => [
                $isUpdate ? 'nullable' : 'required',
                'file',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:2048' // Limite de 2MB
            ],
            
            'estoque_inicial' => 'nullable|integer|min:0'
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O nome do produto é obrigatório.',
            'nome.string' => 'O nome do produto deve ser um texto válido.',
            'nome.max' => 'O nome do produto não pode ter mais de 150 caracteres.',
            'nome.unique' => 'Já existe um produto com esse nome cadastrado.',
            
            'preco.required' => 'O preço é obrigatório.',
            'preco.numeric' => 'O preço deve ser um valor numérico válido.',
            'preco.min' => 'O preço mínimo deve ser de R$ 0,01.',
            
            'categoria_id.required' => 'Selecione uma categoria para o produto.',
            'categoria_id.exists' => 'A categoria selecionada não existe.',
            
            'status.required' => 'O status do produto é obrigatório.',
            'status.in' => 'O status informado é inválido.',
            
            'imagem.required' => 'A imagem do produto é obrigatória.',
            'imagem.image' => 'O arquivo enviado deve ser uma imagem válida.',
            'imagem.mimes' => 'A imagem deve estar nos formatos: jpeg, png, jpg ou webp.',
            'imagem.max' => 'A imagem não pode ser maior que 2MB.',
        ];
    }

    /**
     * Prepara os dados antes da validação
     */
    protected function prepareForValidation()
    {
        // Se o preço vier formatado com padrão brasileiro (ex: 49,90), limpa para o formato numérico (49.90)
        if ($this->has('preco') && is_string($this->preco)) {
            $precoLimpo = str_replace(['R$', ' ', '.'], '', $this->preco);
            $precoLimpo = str_replace(',', '.', $precoLimpo);
            
            $this->merge([
                'preco' => (float) $precoLimpo,
            ]);
        }
    }
}
