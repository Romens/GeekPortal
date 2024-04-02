<?php

namespace App\Http\Requests\Posts;

use App\DTO\Posts\UpdatePostReactionDto;
use App\Enums\Posts\ReactionEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePostReactionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'reaction' => [
                'required',
                Rule::in(ReactionEnum::getAvailableReactions()),
            ],
            'meta' => ['string', 'nullable'],
        ];
    }

    public function getPdo(): UpdatePostReactionDto
    {
        return new UpdatePostReactionDto(
            $this->reaction,
            $this->meta ?? '',
        );
    }
}
