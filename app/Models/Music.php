<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Music
 * @package App\Models
 */
class Music extends Model
{
    /**
     * @var string
     */
    protected $table = 'music';

    /**
     * @param $id
     * @return array
     */
    public function getTrackById($id)
    {
        $a = $this->where('id', $id)->first();
        return $a == null ? $a : $a->toArray();
    }

    /**
     * @param $id
     * @return array
     */
    public function getMusicByAlbumId($id)
    {
        return $this->where('album_id', $id)->get()->toArray();
    }
}
