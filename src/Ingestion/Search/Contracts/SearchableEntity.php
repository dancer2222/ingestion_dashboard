<?php

namespace Ingestion\Search\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface SearchableEntity
{
    public function search(string $needle, array $scopes = []): Builder;
    public function findById(string $id, array $scopes = []): Model;
    public function getModel(): Model;
}
