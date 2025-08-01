<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

const DRAFT = 1;
const SUBMITTED_TO_GSS = 2;
const RECEIVED_BY_GSS = 3;
const APPROVED_BY_GSS = 4;
const SUBMITTED_TO_BUDGET = 5;
const RECEIVED_BY_BUDGET = 6;
const APPROVED_BY_BUDGET = 7;
const SUBMITTED_TO_ORD = 8;
const RECEIVED_BY_ORD = 9;
const APPROVED_BY_ORD = 10;
const RETURNED_BY_GSS = 14;
const RETURNED_BY_BUDGET = 15;
const RETURNED_BY_ORD = 16;
const CANCELLED = 17;

class PurchaseRequestUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public $prId;
    public $statusId;
    public $prNo;
    public $userId;
    public $role;
    public $createdById;
    public $actionOfficerId;

    public function __construct($prId, $statusId, $prNo, $userId, $role, $createdById, $actionOfficerId)
    {
        $this->prId = $prId;
        $this->statusId = $statusId;
        $this->prNo = $prNo;
        $this->userId = $userId;
        $this->role = $role;
        $this->createdById = $createdById;
        $this->actionOfficerId = $actionOfficerId;
       
    }

    public function broadcastOn()
    {
        $channels = [];
    
        if (in_array($this->statusId, [SUBMITTED_TO_GSS, RECEIVED_BY_GSS, APPROVED_BY_GSS, RETURNED_BY_GSS])) {
          
            $channels[] = new Channel('notifications.gss_admin');
        } elseif (in_array($this->statusId, [SUBMITTED_TO_BUDGET, RECEIVED_BY_BUDGET, APPROVED_BY_BUDGET, RETURNED_BY_BUDGET])) {

            $channels[] = new Channel('notifications.budget_admin');
        } elseif (in_array($this->statusId, [SUBMITTED_TO_ORD, RECEIVED_BY_ORD, APPROVED_BY_ORD, RETURNED_BY_ORD])) {
            $channels[] = new Channel('notifications.ord_admin');
        }
    
        if ($this->createdById) {
            $channels[] = new Channel('notifications.' . $this->createdById);
        }
        if ($this->actionOfficerId && $this->actionOfficerId != $this->createdById) {
            $channels[] = new Channel('notifications.' . $this->actionOfficerId);
        }
    
        return array_unique($channels, SORT_REGULAR);
    }

    public function broadcastWith()
    {
        $statusMessages = [
            SUBMITTED_TO_GSS => "Purchase Request #{$this->prNo} submitted to GSS.",
            RECEIVED_BY_GSS => "Purchase Request #{$this->prNo} received by GSS.",
            APPROVED_BY_GSS => "Purchase Request #{$this->prNo} approved by GSS.",
            SUBMITTED_TO_BUDGET => "Purchase Request #{$this->prNo} submitted to Budget.",
            RECEIVED_BY_BUDGET => "Purchase Request #{$this->prNo} received by Budget.",
            APPROVED_BY_BUDGET => "Purchase Request #{$this->prNo} approved by Budget.",
            SUBMITTED_TO_ORD => "Purchase Request #{$this->prNo} submitted to ORD.",
            RECEIVED_BY_ORD => "Purchase Request #{$this->prNo} received by ORD.",
            APPROVED_BY_ORD => "Purchase Request #{$this->prNo} approved by ORD.",
            RETURNED_BY_GSS => "Purchase Request #{$this->prNo} returned by GSS.",
            RETURNED_BY_BUDGET => "Purchase Request #{$this->prNo} returned by Budget.",
            RETURNED_BY_ORD => "Purchase Request #{$this->prNo} returned by ORD.",
            CANCELLED => "Purchase Request #{$this->prNo} cancelled.",
        ];

        return [
            'title' => 'Purchase Request Update',
            'body' => $statusMessages[$this->statusId] ?? "Purchase Request #{$this->prNo} status updated.",
            'prId' => $this->prId,
            'statusId' => $this->statusId, // Added to help frontend update
        ];
    }
}