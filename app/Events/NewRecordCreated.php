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

class NewRecordCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ict_opts;

    public function __construct(RICTUModel $ict_opts)
    {
        $this->ict_opts = $ict_opts;
    }

    // Define the channel name to broadcast to
    public function broadcastOn()
    {
        return new Channel('ict-ta-channel');
    }

    public function broadcastAs()
    {
        return 'new-ict-ta'; // Define the event name
    }
}
