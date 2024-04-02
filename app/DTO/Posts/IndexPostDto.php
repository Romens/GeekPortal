<?php

namespace App\DTO\Posts;

class IndexPostDto implements QuerySearchInterface
{
    public function __construct(
        readonly string $query,
    ) {
    }

    public function getQueryString(): string
    {
        return $this->query;
    }
}
