<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MusicAlbumArtist extends Model
{
    /**
     * @var string
     */
    protected $table = 'music_album_artists';

    public function getArtistByAlbumId($id)
    {
        return $this->where('album_id', $id)->first();
    }
}
