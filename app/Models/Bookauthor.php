<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Bookauthor
 * @package App\Models
 */
class Bookauthor extends Model
{
    protected $table = 'book_authors';

    /**
     * @param $id
     * @return mixed
     */
    public function getIdByAuthorId($id)
    {
        return $this->select('book_id')->where('author_id', $id)->get();
    }
}
