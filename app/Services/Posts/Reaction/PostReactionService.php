<?php

namespace App\Services\Posts\Reaction;

use App\DTO\Posts\UpdatePostReactionDto;
use App\Enums\Posts\ReactionEnum;
use App\Models\Posts\Post;
use App\Models\Posts\Reaction;
use App\Models\User;

final class PostReactionService
{
    public static function getReactionStatistics(Post $post): array
    {
        return [
            'statistics' => self::getReactionsCount($post),
            'userReaction' => self::getUserReactions($post),
        ];
    }

    public static function getReactionsCount(Post $post): array
    {
        $counts = [];

        foreach (ReactionEnum::getAvailableReactions() as $reaction) {
            $counts[$reaction] = $post->reactions()->where('name', $reaction)->count();
        }

        return $counts;
    }

    public static function getUserReactions(Post $post): array
    {
        $userReactions = [];

        if (! auth()->check()) {
            return $userReactions;
        }

        foreach (ReactionEnum::getAvailableReactions() as $reaction) {
            $userReactions[$reaction] = $post
                ->reactions()
                ->where('name', $reaction)
                ->where('user_id', auth('api')->id())
                ->exists();
        }

        return $userReactions;
    }

    public function setUserReactions(UpdatePostReactionDto $dto, Post $post, User $user): void
    {
        $data = [
            'user_id' => $user->id,
            'name' => $dto->getReaction(),
            'entity_uid' => $post->id,
            'entity_type' => Post::getReactionKey(),
        ];

        logger()->debug('test', $data);

        $reaction = Reaction::where($data)->first();

        if (! $reaction) {
            Reaction::create($data + ['meta' => $dto->meta]);
        }
    }

    public function unsetUserReactions(UpdatePostReactionDto $dto, Post $post, User $user): void
    {
        $data = [
            'user_id' => $user->id,
            'name' => $dto->getReaction(),
            'entity_uid' => $post->id,
            'entity_type' => Post::getReactionKey(),
        ];
        Reaction::where($data)->delete();
    }
}
