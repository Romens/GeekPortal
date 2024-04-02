<?php

namespace App\Http\Resources\Posts;

use App\Models\Posts\Post;
use App\Services\Posts\Reaction\PostReactionService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Post $post
 */
class PostsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'text' => $this->resource->text,
            'tags' => TagsResource::collection($this->resource->tags),
            'publish_at' => $this->resource->publish_at,
            'author' => new AuthorPostResource($this->resource->author),
            'reactions' => PostReactionService::getReactionStatistics($this->resource),
        ];
    }
}
