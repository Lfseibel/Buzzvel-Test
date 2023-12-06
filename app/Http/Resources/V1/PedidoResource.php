<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PedidoResource extends JsonResource
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
            'quantidade' => $this->quantidade,
            'data' => $this->data,
            'status' => $this->status,
            'retirada' => $this->retirada,
            'valor_total' => $this->valor_total,
            'produto_id' => $this->produto_id,
            'fornecedor_id' => $this->fornecedor_id,
            'cliente_id' => $this->cliente_id,
            'cliente' => new ClienteResource($this->whenLoaded('cliente')),
            'fornecedor' => new FornecedorResource($this->whenLoaded('fornecedor')),
        ];
    }
}
