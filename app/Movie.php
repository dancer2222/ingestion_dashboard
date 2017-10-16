<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Movie extends Model
{
    protected $table = 'movie';

    public function getMovieById($id)
    {
        return $name = DB::table('movie')
            ->where('id', '=',$id)->get();
    }

    public function getInfoByTitle($title)
    {
        return $id = DB::table('movie')
            ->where('title', '=',$title)->get();
    }
}
