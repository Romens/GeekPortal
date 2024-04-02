<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

abstract class BaseFactory extends Factory
{
    protected function setValue(string $column, $value): BaseFactory
    {
        return $this->state(function () use ($column, $value) {
            return [
                $column => $value,
            ];
        });
    }

    protected function setUser(User $user, string $column = 'user_id'): BaseFactory
    {
        return $this->state(function () use ($column, $user) {
            return [
                $column => $user->id,
            ];
        });
    }
}
