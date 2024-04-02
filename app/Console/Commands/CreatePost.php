<?php

namespace App\Console\Commands;

use App\DTO\Posts\StorePostDto;
use App\Enums\Posts\PostStatus;
use App\Models\User;
use App\Services\Posts\PostsService;
use Illuminate\Console\Command;

class CreatePost extends Command
{
    protected $signature = 'create:post {text?}';

    protected $description = 'Create a new post';

    /**
     * Execute the console command.
     */
    public function handle(PostsService $postsService)
    {
        $author = User::first();

        $postsService->create($this->getPdo(), $author);

    }

    private function getPdo(): StorePostDto
    {
        return new StorePostDto(
            $this->argument('text') ?? fake()->text(),
            'Command post',
            config('posts.default_status', PostStatus::Draft)
        );
    }
}
