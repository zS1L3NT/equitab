<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = ['id' => $this->id];

        /** @var \App\Models\Ledger $ledger */
        $ledger = $request->route('ledger');

        /**
         * Mask away user information if the user has been removed from the ledger
         */
        if (!$ledger || $ledger->users->where('id', $this->id)->whereNull('pivot.deleted_at')->count() == 1) {
            $user['username'] = $this->username;
            $user['phone_number'] = $this->phone_number_verified_at ? $this->phone_number : null;
            $user['picture'] = $this->picture;
        }

        if (isset($this->pivot)) {
            $user['aggregate'] = $this->pivot->aggregate == null ? null : (float) $this->pivot->aggregate;
        }

        return $user;
    }
}
