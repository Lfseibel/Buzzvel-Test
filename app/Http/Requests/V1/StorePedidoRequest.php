<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StorePedidoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //pra usar Rule precisa importar la em cima
            //'tipo' => [Rule::in(['A','a','B','b'])] cria a regra que tipo so pode ter esses 4 valores
            'quantidade' => ['required'],
            'data' => ['required'],
            'status' => ['required'],
            'valor_total' => ['required'],
            'retirada' => ['required'],
            'cliente_id' => ['required'],
            'fornecedor_id' => ['required'],
            'produto_id' => ['required'],
        ];
    }
}
