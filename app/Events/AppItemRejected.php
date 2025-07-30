<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AppItemRejected implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $appItem;
    public $userId;

    public function __construct($appItem, $userId)
    {
        $this->appItem = $appItem;
        $this->userId = $userId;
    }

    public function broadcastOn()
    {
        return new Channel('app-item');
    }

    public function broadcastWith()
    {
        return [
            'app_id' => $this->appItem->id,
            'sn' => $this->appItem->sn ?? '',
            'item_title' => $this->appItem->item_title ?? '',
            'app_status' => $this->appItem->app_status ?? 'rejected',
            'user_id' => $this->userId,
            'message' => 'Your item "' . ($this->appItem->item_title ?? 'Unknown') . '" has been rejected.',
        ];
    }
}
