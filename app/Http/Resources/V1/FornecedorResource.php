<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FornecedorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'cnpj' => $this->cnpj,
            'nprodutos' => $this->produtos()->count(),
            'endereco' => $this->endereco,
            'email' => $this->email,
            'tipo' => $this->tipo,
            'aberto' => $this->aberto,
            'produtos' => ProdutoResource::collection($this->whenLoaded('produtos')),
            'senha' => $this->senha,
            'imagemPerfil' => $this->imagemPerfil,
            'telefone' => $this->telefone,
            'nome' => $this->nome,
        ];
    }
}
