<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'name' => $this->name,
            'cost' => $this->cost,
            'location' => $this->location,
            'datetime' => $this->datetime,
            'category' => $this->category,
            'payer' => new UserResource($this->payer),
            'owers' => UserResource::collection($this->owers),
            'ledger' => new LedgerResource($this->whenLoaded('ledger')),
            'products' => ProductResource::collection($this->whenLoaded('products')),
            'product_count' => $this->whenCounted('products'),
        ];
    }
}
