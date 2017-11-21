<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MusicArtist extends Model
{
    /**
     * @var string
     */
    protected $table = 'music_artist';

    /**
     * @param $id
     * @return array
     */
    public function getNameArtistByArtistId($id)
    {
        return $this->where('id', $id)->first()->toArray();
    }
}
