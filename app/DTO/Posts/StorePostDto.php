<?php

namespace App\DTO\Posts;

use App\Enums\Posts\PostStatus;
use Carbon\Carbon;

class StorePostDto
{
    public function __construct(
        readonly string $text,
        readonly ?string $title = null,
        readonly PostStatus $status = PostStatus::Draft,
        readonly array $tags = [],
        readonly ?Carbon $publish_at = null,
    ) {
    }

    public function all(): array
    {
        return [
            'title' => $this->title,
            'text' => $this->text,
            'status' => $this->status,
            'publish_at' => $this->publish_at,
        ];
    }
}
