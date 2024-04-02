<?php

namespace App\Models\Posts;

use App\Enums\Posts\PostStatus;
use App\Interfaces\Posts\PostAuthor;
use App\Models\User;
use App\Services\Posts\SearchStringBuilder;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $author_id
 * @property string $title
 * @property string $text
 * @property string $url
 * @property PostStatus $status
 * @property string|Carbon $publish_at
 *
 * @method static Builder|Post status(PostStatus $status)
 * @method static Builder|Post search(string $search)
 */
class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'status' => PostStatus::class,
        'publish_at' => 'datetime',
    ];

    protected $fillable = [
        'title',
        'text',
        'url',
        'author_id',
        'status',
        'publish_at',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }

    public function reactions(): HasMany
    {
        return $this
            ->hasMany(Reaction::class, 'entity_uid', 'id')
            ->where('entity_type', self::getReactionKey());
    }

    public function scopePublish(): Builder
    {
        return $this
            ->where('publish_at', '<', now())
            ->status(PostStatus::Public);
    }

    public function scopeSearch(Builder $builder, string $search = ''): Builder
    {
        if (empty($search)) {
            return $builder;
        }

        $searchBuilder = new SearchStringBuilder($search);

        return $builder
            ->when(! empty($searchBuilder->buildLike()), function (Builder $builder) use ($searchBuilder) {
                $builder->where('text', 'like', $searchBuilder->buildLike());
            })
            ->when(! empty($searchBuilder->buildDisLike()), function (Builder $builder) use ($searchBuilder) {
                $builder->whereNot('text', 'like', $searchBuilder->buildDisLike());
            });
    }

    public function scopeStatus(Builder $builder, PostStatus $status): Builder
    {
        return $builder->where('status', $status);
    }

    public function setAuthor(PostAuthor $postAuthor): void
    {
        $this->author_id = $postAuthor->getKey();
    }

    public static function getReactionKey(): string
    {
        return 'post';
    }

    public function isPublish(): bool
    {
        return $this->status === PostStatus::Public && $this->publish_at->timestamp <= now()->timestamp;
    }
}
