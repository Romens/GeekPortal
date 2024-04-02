<?php

namespace App\Services\Posts;

use App\Models\Posts\Post;
use App\Models\Posts\Tag;
use Illuminate\Support\Collection;

final class TagsService
{
    public function syncTagsWithPost(Post $post, iterable $tags): Post
    {
        $tags = array_map('strtolower', (array) $tags);
        $tagModels = $this->getOrUpdateTags($tags);
        $post->tags()->sync($tagModels->pluck('id'));

        return $post;
    }

    private function getOrUpdateTags(iterable $tags): Collection
    {
        $existTagModels = Tag::whereIn(column: 'name', values: $tags)->get()->keyBy('name');

        return collect($tags)->map(function ($tag) use ($existTagModels) {
            return $existTagModels[$tag] ?? $this->createTag($tag);
        });
    }

    private function createTag(string $name): Tag
    {
        return Tag::create(['name' => $name]);
    }
}
