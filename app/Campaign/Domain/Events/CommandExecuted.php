<?php

namespace App\Campaign\Domain\Events;

use App\Campaign\Domain\Classes\Command;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CommandExecuted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $cmd;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Command $cmd)
    {
        $this->cmd = $cmd;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
