<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Audiobookauthor extends Model
{
    protected $table = 'audio_book_authors';

    public function getIdByAuthorId($id)
    {
        return $this->select('audio_book_id')->where('author_id', $id)->get();
    }
}
