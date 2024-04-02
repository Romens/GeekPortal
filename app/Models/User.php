<?php

namespace App\Models;

use App\Interfaces\Posts\PostAuthor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * @property int $id
 * @property string $name
 * @property string $url
 * @property string $email
 * @property string $password
 */
class User extends Authenticatable implements PostAuthor
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $appends = [
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAvatarAttribute(): string
    {
        return $this->getGravatarAttribute();
    }

    public function getGravatarAttribute(): string
    {
        return 'https://gravatar.com/avatar/'.hash('sha256', strtolower(trim($this->email)));
    }
}
