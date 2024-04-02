<?php

namespace App\Http\Requests\Posts;

use App\DTO\Posts\UpdatePostDto;
use App\Enums\Posts\PostStatus;
use Carbon\Carbon;

class UpdatePostRequest extends BaseCreateRequest
{
    public function getPdo(): UpdatePostDto
    {
        return new UpdatePostDto(
            $this->text,
            $this->title,
            $this->status = config('posts.default_status', PostStatus::Draft),
            $this->tags = $this->getTags(),
            $this->publish_at = Carbon::now()
        );
    }
}
