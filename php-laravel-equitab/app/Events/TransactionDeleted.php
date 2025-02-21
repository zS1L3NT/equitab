<?php

namespace App\Events;

use App\Models\Transaction;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TransactionDeleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;//, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Transaction $transaction)
    {
        //
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('ledgers.' . $this->transaction->ledger_id . '.transactions')
        ];
    }

    public function broadcastAs(): string
    {
        return 'transaction.deleted';
    }

    public function broadcastWith(): array
    {
        return [
            'transaction' => [
                'id' => $this->transaction->id
            ]
        ];
    }
}
