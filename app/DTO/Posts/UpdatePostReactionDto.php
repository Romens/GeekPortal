<?php

namespace App\DTO\Posts;

class UpdatePostReactionDto
{
    public function __construct(
        readonly string $reaction,
        readonly string $meta = '',
    ) {

    }

    public function getReaction(): string
    {
        return $this->reaction;
    }

    public function getMeta(): string
    {
        return $this->meta;
    }
}
