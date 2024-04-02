<?php

namespace Database\Factories\Posts;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Posts\Tag>
 */
class TagFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->word,
        ];
    }
}
