<?php

namespace App\Events;

use App\Models\Ledger;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LedgerDeleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;//, SerializesModels;

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
        return 'ledger.deleted';
    }

    public function broadcastWith(): array
    {
        return [
            'ledger' => [
                'id' => $this->ledger->id
            ]
        ];
    }
}
