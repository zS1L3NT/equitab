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

class LedgerUpdated implements ShouldBroadcast
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
        return [
            new PrivateChannel('ledgers.' . $this->ledger->id)
        ];
    }

    public function broadcastAs(): string
    {
        return 'ledger.updated';
    }

    public function broadcastWith(): array
    {
        return [
            'ledger' => new LedgerResource($this->ledger)
        ];
    }
}
