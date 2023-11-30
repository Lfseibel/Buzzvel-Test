<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProdutoResource extends JsonResource
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
            'nome' => $this->nome,
            'valor' => $this->valor,
            'descricao' => $this->descricao,
            'disponivel' => $this->disponivel,
            'fornecedorId' => $this->fornecedor_id
        ];
    }
}
