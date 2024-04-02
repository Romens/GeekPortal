<?php

namespace Tests\UserCases\Posts;

use App\Models\Posts\Post;
use App\Models\User;
use Tests\TestCase;

class AuthorCaseTest extends TestCase
{
    private User $author;

    protected function setUp(): void
    {
        parent::setUp();

        $this->author = User::factory()->create();
    }

    /**
     * @test
     *
     * @group posts
     */
    public function authorCanPostSimple(): void
    {
        $this
            ->actingAs($this->author, 'api')
            ->post(route('posts.store'), [
                'title' => 'title',
                'text' => 'text',
            ])
            ->assertStatus(201);
    }

    /**
     * @test
     *
     * @group posts
     */
    public function authorCanPostWithTagsAndSeeDraft(): void
    {
        $this
            ->actingAs($this->author, 'api')
            ->post(route('posts.store'), [
                'title' => 'I visited GeekPortal.org!',
                'text' => "It's awesome portal!",
                'tags' => [
                    'GeekPortal',
                    'opinion',
                ],
            ])
            ->assertStatus(201);

        $this->assertDatabaseHas('tags', ['name' => 'geekportal']);
        $this->assertDatabaseHas('posts', ['title' => 'I visited GeekPortal.org!', 'text' => "It's awesome portal!"]);
    }

    /**
     * @test
     *
     * @group posts
     */
    public function authorCanUpdateDraftPost(): void
    {
        $post = Post::factory()->draft()->create();

        $this
            ->actingAs($this->author, 'api')
            ->patch(route('posts.update', $post), [
                'title' => 'I visited GeekPortal.org!',
                'text' => "It's still awesome portal!",
                'tags' => [
                    'geekportal',
                    'opinion',
                ],
            ])
            ->assertStatus(200);
    }
}
