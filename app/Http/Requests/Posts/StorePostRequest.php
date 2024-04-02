<?php

namespace App\Http\Requests\Posts;

use App\DTO\Posts\StorePostDto;
use App\Enums\Posts\PostStatus;
use Carbon\Carbon;

class StorePostRequest extends BaseCreateRequest
{
    public function getPdo(): StorePostDto
    {
        return new StorePostDto(
            $this->text,
            $this->title,
            $this->status = config('posts.default_status', PostStatus::Draft),
            $this->tags = $this->getTags(),
            $this->publish_at = Carbon::now()
        );
    }
}
