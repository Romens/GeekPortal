<?php

namespace App\DTO\Posts;

interface QuerySearchInterface
{
    public function getQueryString(): string;
}
