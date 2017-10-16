<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Album extends Model
{
    protected $table = 'music_album';

    public function getAlbumById($id)
    {
        return $name = DB::table('music_album')
            ->where('id', '=',$id)->get();
    }
}
