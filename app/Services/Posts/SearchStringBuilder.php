<?php

namespace App\Services\Posts;

use App\DTO\Posts\QuerySearchInterface;

final class SearchStringBuilder implements QuerySearchInterface
{
    private array $exploded;

    public function __construct(
        private readonly string $searchQuery,
        private readonly string $explode = ' ',
        private readonly string $dislike = '-',
    ) {
        $this->exploded = explode($this->explode, $this->searchQuery);
    }

    public function buildLike(): string|array
    {
        $array = collect($this->exploded)
            ->map(function ($initValue) {
                if (substr($initValue, 0, 1) === $this->dislike) {
                    return;
                }

                return '%'.$initValue.'%';
            })
            ->filter();

        return $array->all();
    }

    public function buildDisLike(): array
    {
        $array = collect($this->exploded)
            ->map(function ($initValue) {
                if (substr($initValue, 0, 1) === $this->dislike) {
                    return $initValue;
                }

            })
            ->filter();

        return $array->all();
    }

    public function getQueryString(): string
    {
        return $this->searchQuery;
    }
}
