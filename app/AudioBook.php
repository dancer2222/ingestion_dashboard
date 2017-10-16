<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AudioBook extends Model
{
    protected $table = 'audio_book';

    public function getAudioBookById($id)
    {
        return $name = DB::table('audio_book')
            ->where('id', '=',$id)->get();
    }

    public function getInfoByTitle($title)
    {
        return $id = DB::table('audio_book')
            ->where('title', '=',$title)->get();
    }
}
