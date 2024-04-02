<?php

namespace App\Http\Requests\Posts;

use App\Enums\Posts\PostStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\In;

abstract class BaseCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return $this->baseRules();
    }

    protected function baseRules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'text' => ['required', 'string', 'min:3'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['string'],
            'status' => ['nullable', 'string', new In(PostStatus::availableStatuses())],
            'publish_at' => ['nullable', 'datetime'],
        ];
    }

    protected function getTags(): array
    {
        $value = $this->tags;
        $tags = [];

        if (is_string($value)) {
            if (str_contains(', ', $value)) {
                $tags = explode(',', $value);
            } else {
                $tags[] = $value;
            }
        }

        if (is_array($value)) {
            $tags = collect($value)->flatten()->all();
        }

        return $tags;
    }
}
