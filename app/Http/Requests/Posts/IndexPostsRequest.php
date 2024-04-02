<?php

namespace App\Http\Requests\Posts;

use App\DTO\Posts\IndexPostDto;
use Illuminate\Foundation\Http\FormRequest;

class IndexPostsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string'],
        ];
    }

    public function getPdo(): IndexPostDto
    {
        return new IndexPostDto($this->search ?? '');
    }
}
