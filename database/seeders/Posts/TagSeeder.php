<?php

namespace Database\Seeders\Posts;

use App\Models\Posts\Tag;
use Database\Seeders\BaseSeeder;

class TagSeeder extends BaseSeeder
{
    protected $class = Tag::class;

    protected ?string $uniqueKey = 'name';

    protected $info = [
        ['name' => 'geekportal'],
        ['name' => 'main'],
        ['name' => 'secondary'],
        ['name' => 'php'],
        ['name' => 'laravel'],
    ];
}
