<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CatalogosRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome'              => 'required|string|max:100',
            'tipo_catalogo_id'  => 'required|integer|exists:tipo_catalogo,id',
            'status_id'         => 'required|integer|exists:status_catalogo,id',
            'descricao'         => 'nullable|string',
            'data_encerramento' => 'required|date_format:d/m/Y',
            'data_publicacao'   => 'required|date_format:d/m/Y',
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required'                 => 'O campo nome é obrigatório.',
            'nome.string'                   => 'O campo nome deve ser um texto.',
            'nome.max'                      => 'O nome deve ter no máximo 100 caracteres.',
            'tipo_catalogo_id.required'     => 'O tipo do catálogo é obrigatório.',
            'tipo_catalogo_id.integer'      => 'O tipo do catálogo deve ser um número inteiro.',
            'tipo_catalogo_id.exists'       => 'O tipo de catálogo informado não existe.',
            'status_id.required'            => 'O status é obrigatório.',
            'status_id.integer'             => 'O status deve ser um número inteiro.',
            'status_id.exists'              => 'O status informado não existe.',
            'data_encerramento.required'    => 'A data de encerramento é obrigatória.',
            'data_encerramento.date_format' => 'A data de encerramento deve estar no formato dd/mm/aaaa.',
            'data_publicacao.required'      => 'A data de publicação é obrigatória.',
            'data_publicacao.date_format'   => 'A data de publicação deve estar no formato dd/mm/aaaa.',
        ];
    }
}
