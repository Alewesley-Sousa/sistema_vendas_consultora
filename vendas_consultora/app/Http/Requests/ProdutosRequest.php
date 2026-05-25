<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdutosRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('put') || $this->isMethod('patch');

        return [
            'nome' => [$isUpdate ? 'sometimes' : 'required', 'string', 'max:150'],
            'preco' => [$isUpdate ? 'sometimes' : 'required', 'numeric', 'min:0'],
            'descricao' => ['nullable', 'string', 'max:500'],
            'categoria_id' => ['required', 'integer', 'exists:categorias,id'],
            'status' => [$isUpdate ? 'sometimes' : 'required', 'string', 'in:ativo,inativo'],
            
            // Tratamento correto do arquivo de imagem vindo do front-end
            'imagem' => [
                $isUpdate ? 'nullable' : 'required',
                'file',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:2048'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O nome do produto é obrigatório.',
            'preco.required' => 'O preço é obrigatório.',
            'preco.numeric' => 'O preço deve ser um valor numérico.',
            'categoria_id.required' => 'A categoria é obrigatória.',
            'categoria_id.exists' => 'A categoria selecionada não existe.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'O status deve ser ativo ou inativo.',
            'imagem.required' => 'A imagem do produto é obrigatória.',
            'imagem.image' => 'O arquivo enviado deve ser uma imagem válida.',
            'imagem.max' => 'A imagem não pode ser maior que 2MB.',
        ];
    }
}
