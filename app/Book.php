<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Book extends Model
{
    protected $table = 'book';

    public function getBookById($id)
    {
        return $name = DB::table('book')
            ->where('id', '=',$id)->get();
    }

    public function getInfoByTitle($title)
    {
        return $id = DB::table('book')
            ->where('title', '=',$title)->get();
    }
}
