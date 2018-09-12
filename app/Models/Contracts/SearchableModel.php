<?php

namespace App\Models\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface SearchableModel
{
    public function seek(string $needle, array $scopes = []): Builder;
    public function seekById(string $id, array $scopes = []);
}
