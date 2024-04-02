<?php

namespace App\Services\Posts;

use App\DTO\Posts\QuerySearchInterface;
use App\DTO\Posts\StorePostDto;
use App\Events\PostCreated;
use App\Events\PostUpdated;
use App\Interfaces\Posts\PostAuthor;
use App\Models\Posts\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

final class PostsService
{
    public function __construct(
        readonly TagsService $tagsService,
    ) {
    }

    protected function getQuery(?PostAuthor $postAuthor = null): Post|Builder
    {
        $query = Post::publish();

        $query->with('author', 'reactions');

        if ($postAuthor) {
            $query = $query->orWhere('author_id', $postAuthor->getKey());
        }

        return $query;
    }

    public function get(?PostAuthor $postAuthor = null)
    {
        return $this->getQuery($postAuthor)->get();
    }

    public function getPagination(QuerySearchInterface $search, ?PostAuthor $postAuthor = null, int $perPage = 20): LengthAwarePaginator
    {
        $query = $this
            ->getQuery($postAuthor)
            ->search($search->getQueryString())
            ->orderBy('created_at', 'desc');

        PostsLogger::query($query, 'Get post with search service');

        return $query->paginate($perPage);
    }

    public function getOne(string $articleUrl): ?Post
    {
        $query = Post::query()
            ->publish()
            ->where('url', $articleUrl);

        return $query->first();
    }

    public function create(StorePostDto $dto, User $author): Post
    {
        $post = new Post($dto->all());
        $post->setAuthor($author);
        $post->save();
        $this->tagsService->syncTagsWithPost($post, $dto->tags);

        broadcast(new PostCreated($post));
        dump('Created post: '.$post->id);

        return $post->refresh();
    }

    public function update(StorePostDto $dto, Post $post): Post
    {
        $post = $post->fill($dto->all());
        $post->save();

        if (count($dto->tags) > 0) {
            $this->tagsService->syncTagsWithPost($post, $dto->tags);
        }

        broadcast(new PostUpdated($post));

        dump('Craeted post: '.$post->id);

        return $post->refresh();
    }
}
