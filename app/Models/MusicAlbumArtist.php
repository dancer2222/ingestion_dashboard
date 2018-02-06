<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MusicAlbumArtist
 * @package App\Models
 */
class MusicAlbumArtist extends Model
{
    /**
     * @var string
     */
    protected $table = 'music_album_artists';

    /**
     * @param $id
     * @return mixed
     */
    public function getArtistByAlbumId($id)
    {
        return $this->where('album_id', $id)->get();
    }
}
