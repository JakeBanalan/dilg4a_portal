<?php

namespace App\Events;

use App\Models\RICTUModel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class RecievedRecord implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $receivedTA;

    public function __construct(RICTUModel $receivedTA)
    {
        $this->receivedTA = $receivedTA;
    }

    // Define the channel name to broadcast to
    public function broadcastOn()
    {
        return new Channel('received-ta-channel');
    }

    public function broadcastAs()
    {
        return 'received-ict-ta'; // Define the event name
    }
}
