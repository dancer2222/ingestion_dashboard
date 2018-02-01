<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class Album
 * @package App\Models
 */
class Album extends Model
{
    /**
     * @var string
     */
    protected $table = 'music_album';

    /**
     * @param $id
     * @return mixed
     */
    public static function getInfoById($id)
    {
        return DB::table('music_album')->where('id', $id)->get();
    }

    /**
     * @param $title
     * @return mixed
     */
    public static function getInfoByTitle($title)
    {
        return DB::table('music_album')
            ->where('title', $title)->get();
    }

    /**
     * @param $upc
     *
     * @return mixed
     */
    public static function getInfoByUpc($upc)
    {
        return DB::table('music_album')
            ->where('upc', $upc)->get();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getBatchInfoForAlbums($id)
    {
        return DB::table('music_album_artists as maa')
            ->select(DB::raw("
                                GROUP_CONCAT(DISTINCT maa.seq_id SEPARATOR ', ') AS seq_id,
                                GROUP_CONCAT(DISTINCT ma.id SEPARATOR ', ') AS id,
                                GROUP_CONCAT(DISTINCT ma.title SEPARATOR ', ') AS title,
                                GROUP_CONCAT(DISTINCT ma.description SEPARATOR ', ') AS description,
                                GROUP_CONCAT(DISTINCT ma.release_date SEPARATOR ', ') AS release_date,
                                GROUP_CONCAT(DISTINCT ma.date_added SEPARATOR ', ') AS date_added,
                                GROUP_CONCAT(DISTINCT ma.premium SEPARATOR ', ') AS premium,
                                GROUP_CONCAT(DISTINCT ma.total_num_views SEPARATOR ', ') AS total_num_views,
                                GROUP_CONCAT(DISTINCT ma.average_rating SEPARATOR ', ') AS average_rating,
                                GROUP_CONCAT(DISTINCT ma.status SEPARATOR ', ') AS status,
                                GROUP_CONCAT(DISTINCT ma.format SEPARATOR ', ') AS format,
                                GROUP_CONCAT(DISTINCT ma.total_listens SEPARATOR ', ') AS total_listens,
                                GROUP_CONCAT(DISTINCT ma.popularity SEPARATOR ', ') AS popularity,
                                GROUP_CONCAT(DISTINCT ma.data_origin_status SEPARATOR ', ') AS data_origin_status,
                                GROUP_CONCAT(DISTINCT ma.date_published SEPARATOR ', ') AS date_published,
                                GROUP_CONCAT(DISTINCT ma.duration SEPARATOR ', ') AS duration,
                                GROUP_CONCAT(DISTINCT licen.name SEPARATOR ', ') AS licensor_name
            "))
            ->leftJoin('music_album as ma', 'maa.album_id', 'ma.id')
            ->leftJoin('licensors as licen', 'ma.licensor_id', 'licen.id')
            ->where('maa.batch_id', $id)
            ->groupBy('maa.album_id')
            ->get();
    }
}
