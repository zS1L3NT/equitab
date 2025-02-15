<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LedgerResource extends JsonResource
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
            'picture' => $this->picture,
            'aggregate' => $this->whenPivotLoaded('ledger_user', $this->pivot?->aggregate == null ? null : (float) $this->pivot->aggregate),
            'currency' => $this->currency->toArray(),
            'users' => UserResource::collection($this->whenLoaded('users')),
        ];
    }
}
