<?php

namespace App\Services\Posts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface;

final class PostsLogger
{
    private static function logger(): LoggerInterface
    {
        return Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/posts.log'),
        ]);
    }

    public static function query(Builder $query, string $message = 'Query'): void
    {
        self::logger()->info($message, [
            'sql' => $query->toSql(),
            'bindings' => $query->getBindings(),
            'queryRaw' => $query->toRawSql(),
        ]);
    }
}
