<?php

namespace App\Events;

use App\Models\Product;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductDeleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;//, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Product $product)
    {
        //
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('ledgers.' . $this->product->ledger()->id() . '.transactions'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'product.deleted';
    }

    public function broadcastWith(): array
    {
        return [
            'product' => [
                'id' => $this->product->id
            ]
        ];
    }
}
