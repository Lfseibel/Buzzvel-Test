<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFornecedorRequest extends FormRequest
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
            'cnpj' => ['required','unique:fornecedors'],
            'senha' => ['required'],
            'email' => ['required','email','unique:fornecedors'],
            'endereco' => ['required'],
            'tipo' => ['required'],
            'aberto' => ['required'],
            'descricao' => ['required'],
            'imagemPerfil' => ['nullable','image','mimes:jpeg,jpg,png,gif,svg','max:2048'],
            'telefone' => ['required']
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'imagem_perfil' => $this->imagemPerfil
        ]);
    }
}
