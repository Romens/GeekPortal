<?php

namespace Database\Factories\Posts;

use App\Enums\Posts\PostStatus;
use App\Models\User;
use Carbon\Carbon;
use Database\Factories\BaseFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Posts\Post>
 */
class PostFactory extends BaseFactory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'text' => $this->faker->paragraph,
            'author_id' => User::factory(),
        ];
    }

    public function publish(Carbon $carbon): PostFactory
    {
        return $this
            ->setValue('publish_at', $carbon)
            ->status(PostStatus::Public);
    }

    public function author(User $author): PostFactory
    {
        return $this->setValue('author_id', $author);
    }

    public function draft(): PostFactory
    {
        return $this->status(PostStatus::Draft);
    }

    public function moderation(): PostFactory
    {
        return $this->status(PostStatus::Moderation);
    }

    public function public(): PostFactory
    {
        return $this->status(PostStatus::Public);
    }

    public function status(PostStatus $status): PostFactory
    {
        return $this->setValue('status', $status->value);
    }
}
