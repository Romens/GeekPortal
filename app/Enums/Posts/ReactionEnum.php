<?php

namespace App\Enums\Posts;

enum ReactionEnum: string
{
    const Love = '❤️';

    const Like = '👍';

    const Dislike = '👎';

    const Thinking = '🤔';

    const Poop = '💩';

    public static function getAvailableReactions(): array
    {
        return [
            self::Love,
            self::Like,
            self::Dislike,
            self::Thinking,
            self::Poop,
        ];
    }
}
