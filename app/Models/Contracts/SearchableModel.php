<?php

namespace App\Models\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface SearchableModel
{
    public function seek(string $needle, array $with = [], array $has = []): Builder;
    public function seekById(string $id, array $with = [], array $has = []);
}
