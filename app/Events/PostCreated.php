<?php

namespace App\Events;

use App\Http\Resources\Posts\PostsResource;
use App\Models\Posts\Post;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PostCreated implements ShouldBroadcast, ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(readonly Post $post)
    {
    }

    /**
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('chat'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'post.created';
    }

    public function broadcastWhen(): bool
    {
        return $this->post->isPublish();
    }

    public function broadcastWith(): array
    {
        return [
            'post' => new PostsResource($this->post),
        ];
    }
}
