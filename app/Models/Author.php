<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $table = 'author';

    public function getIdByName($name)
    {
        return $this->select('id')
            ->where('name', $name)
            ->get();
    }
}
