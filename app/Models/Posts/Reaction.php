<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $entity_type
 */
class Reaction extends Model
{
    protected $fillable = [
        'entity_uid',
        'entity_type',
        'name',
        'user_id',
        'meta',
    ];
}
