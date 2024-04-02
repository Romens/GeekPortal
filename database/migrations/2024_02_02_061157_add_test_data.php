<?php

use App\Models\Posts\Tag;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        $countOfTestPosts = 100;

        [$adminUser, $demoUser] = $this->createTestUsers();

        for ($i = 0; $i < $countOfTestPosts; $i++) {
            $this->createTestPost($demoUser, $adminUser);
        }
    }

    public function down(): void
    {
        \App\Models\User::query()->delete();
        \App\Models\Posts\Post::query()->delete();
    }

    public function createTestUsers(): array
    {
        $adminUser = \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin'),
        ]);
        $demoUser = \App\Models\User::create([
            'name' => 'demo',
            'email' => 'demo@example.com',
            'password' => Hash::make('demo'),
        ]);

        return [$adminUser, $demoUser];
    }

    public function createTestPost(\App\Interfaces\Posts\PostAuthor $author, ?\App\Models\User $user = null): \App\Models\Posts\Post
    {
        $post = \App\Models\Posts\Post::create([
            'title' => 'Test post by '.$author->getKey().' user!',
            'text' => fake()->text(mt_rand(120, 700)),
            'status' => \App\Enums\Posts\PostStatus::Public,
            'publish_at' => now(),
            'author_id' => $author->getKey(),
        ]);
        $tag = Tag::createOrFirst(['name' => 'test']);
        $post->tags()->sync([$tag->id]);

        \App\Models\Posts\Reaction::create([
            'entity_uid' => $post->id,
            'entity_type' => \App\Models\Posts\Post::getReactionKey(),
            'name' => \App\Enums\Posts\ReactionEnum::Like,
            'user_id' => $user?->id,
        ]);

        return $post;
    }
};
