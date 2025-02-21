<?php

namespace App\Events;

use App\Models\LedgerUser;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LedgerUserCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public LedgerUser $pivot)
    {
        //
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('users.' . $this->pivot->user_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'ledger.user.created';
    }

    public function broadcastWith(): array
    {
        return [
            'ledger' => [
                'id' => $this->pivot->ledger_id
            ]
        ];
    }
}
