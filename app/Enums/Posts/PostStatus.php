<?php

namespace App\Enums\Posts;

enum PostStatus: string
{
    case Draft = 'draft';
    case Moderation = 'moderation';
    case Public = 'public';

    public static function availableStatuses(): array
    {
        return [
            self::Draft,
            self::Public,
        ];
    }
}
