<?php

namespace App\Models\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface ContentSmartSearchContract
{
    public function smartSearch(string $needle, $query = null): Builder;
}
