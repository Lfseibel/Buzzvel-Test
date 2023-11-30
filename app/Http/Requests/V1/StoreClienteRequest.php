<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends FormRequest
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
            'nome' => ['required'],
            //pra usar Rule precisa importar la em cima
            //'tipo' => [Rule::in(['A','a','B','b'])] cria a regra que tipo so pode ter esses 4 valores
            'telefone' => ['required'],
            'senha' => ['required'],
            'email' => ['required','email','unique:clientes'],
            'endereco' => ['required'],
            'cpf' => ['required'],
            'imagem_perfil' => ['nullable','image','mimes:jpeg,jpg,png,gif,svg','max:2048'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'imagem_perfil' => $this->imagem_perfil
        ]);
    }
}
