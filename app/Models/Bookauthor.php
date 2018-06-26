<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookauthor extends Model
{
    protected $table = 'book_authors';

    public function getIdByAuthorId($id)
    {
        return $this->select('book_id')->where('author_id', $id)->get();
    }
}
