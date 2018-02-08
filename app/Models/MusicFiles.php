<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MusicFiles
 * @package App\Models
 */
class MusicFiles extends Model
{
    /**
     * @var string
     */
    protected $table = 'music_files';

    /**
     * @param $id
     * @return mixed
     */
    public function getGeoRestrictMusicFilesById($id)
    {
        return $this->where('music_id', $id)
            ->select('region', 'status')
            ->get();
    }

}
