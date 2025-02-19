<?php

namespace App\Events;

use App\Http\Resources\LedgerResource;
use App\Models\Ledger;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LedgerCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Ledger $ledger)
    {
        //
    }

    public function broadcastOn(): array
    {
        return $this->ledger->users()->pluck('id')->map(fn($u) => new PrivateChannel('users.' . $u))->toArray();
    }

    public function broadcastAs(): string
    {
        return 'ledger.created';
    }

    public function broadcastWith(): array
    {
        return [
            'ledger' => new LedgerResource($this->ledger)
        ];
    }
}
