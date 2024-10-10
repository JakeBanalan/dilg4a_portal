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

class CompleteTa implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $completedTA;

    public function __construct(RICTUModel $completedTA)
    {
        $this->completedTA = $completedTA;
    }

    // Define the channel name to broadcast to
    public function broadcastOn()
    {
        return new Channel('completed-ta-channel');
    }

    public function broadcastAs()
    {
        return 'completed-ict-ta'; // Define the event name
    }
}
