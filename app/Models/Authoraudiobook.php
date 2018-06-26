<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Authoraudiobook extends Model
{
    protected $table = 'author_audio_book';

    public function getIdByName($name)
    {
        return $this->select('id')
            ->where('name', $name)
            ->get();
    }
}
