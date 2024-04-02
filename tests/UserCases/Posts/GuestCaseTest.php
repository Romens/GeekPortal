<?php

namespace Tests\UserCases\Posts;

use App\Models\Posts\Post;
use Tests\TestCase;

class GuestCaseTest extends TestCase
{
    private $guest = null;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     *
     * @group posts
     */
    public function guestCanSeeOnlyPublishPosts(): void
    {
        Post::query()->delete();
        $postDraft = Post::factory()->draft()->create();
        $postPublishWithFutureDate = Post::factory()->publish(now()->addDay())->create();
        $postPublishWithOldPublishAt = Post::factory()->publish(now()->subDay())->create();

        $this
            ->get(route('posts.index'))
            ->dump()
            ->assertOk()
            ->assertJsonMissing(['title' => $postDraft->title])
            ->assertJsonMissing(['title' => $postPublishWithFutureDate->title])
            ->assertJsonFragment(['title' => $postPublishWithOldPublishAt->title]);
    }
}
