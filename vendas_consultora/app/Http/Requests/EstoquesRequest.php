<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstoquesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'produto_id' => ['required', 'integer', 'exists:produtos,id'],
            'quantidade'  => ['required', 'integer', 'min:0'],
        ];
    }
}