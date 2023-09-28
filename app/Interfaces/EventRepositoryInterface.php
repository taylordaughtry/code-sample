<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Support\Collection;

interface EventRepositoryInterface
{
    public function byUserId(int $id): Collection;
}