<?php

namespace App\Events;

use App\Http\Models\Article;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PostViewCount
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Post
     */
    public $post;

    /**
     * @var string
     */
    public $ip;

    /**
     * Create a new event instance.
     *
     * @param Post $post
     * @param string $ip
     */
    public function __construct(Article $post, $ip)
    {
        $this->post = $post;
        $this->ip   = $ip;
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
