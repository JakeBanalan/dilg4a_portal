<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AppItemApproved implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $appItem;
    public $userId;

    /**
     * Create a new event instance.
     *
     * @param mixed $appItem The AppItemModel instance
     * @param int $userId The ID of the user who created the item (tbl_app.created_by)
     */
    public function __construct($appItem, $userId)
    {
        $this->appItem = $appItem;
        $this->userId = $userId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel
     */
    public function broadcastOn()
    {
        return new Channel('app-item');
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'app_id' => $this->appItem->id,
            'sn' => $this->appItem->sn ?? '',
            'item_title' => $this->appItem->item_title ?? '',
            'app_status' => $this->appItem->app_status ?? 'approve',
            'mode_of_proc_title' => $this->appItem->mode_of_proc_title ?? 'Not Set',
            'user_id' => $this->userId,
            'message' => 'Your item "' . ($this->appItem->item_title ?? 'Unknown') . '" has been approved.',
        ];
    }
}
