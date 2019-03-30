<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Chat;

class ChatSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    private $chat;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Chat $chat)
    {
        $chat->User;
        $chat->Receiver;
        $this->chat = $chat;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('my-channel');
    }

    public function broadcastAs()
    {
        return 'chat-sent.'.$this->chat->Receiver->id;
    }

    public function broadcastWith()
    {
        return [
            'chat' => $this->chat,
        ];
    }
}
