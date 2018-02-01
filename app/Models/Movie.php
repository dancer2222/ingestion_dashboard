<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class Movie
 * @package App\Models
 */
class Movie extends Model
{
    /**
     * @var string
     */
    protected $table = 'movie';

    /**
     * @param $id
     * @return mixed
     */
    public static function getInfoById($id)
    {
        return DB::table('movie')->where('id', $id)->get();
    }

    /**
     * @param $title
     * @return mixed
     */
    public static function getInfoByTitle($title)
    {
        return DB::table('movie')
            ->where('title', $title)->get();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getBatchInfoForMovies($id)
    {
        return DB::table('movie as m')
            ->select(DB::raw("
                                m.id, 
                                    GROUP_CONCAT(DISTINCT m.title SEPARATOR ', ') AS title,
                                    GROUP_CONCAT(DISTINCT m.description SEPARATOR ', ') AS description,
                                    GROUP_CONCAT(DISTINCT m.duration SEPARATOR ', ') AS duration,
                                    GROUP_CONCAT(DISTINCT m.release_year SEPARATOR ', ') AS release_year,
                                    GROUP_CONCAT(DISTINCT m.ma_release_date SEPARATOR ', ') AS ma_release_date,
                                    GROUP_CONCAT(DISTINCT m.mpaa_rating SEPARATOR ', ') AS mpaa_rating,
                                    GROUP_CONCAT(DISTINCT m.status SEPARATOR ', ') AS status,
                                    GROUP_CONCAT(DISTINCT m.date_published SEPARATOR ', ') AS date_published,
                                    GROUP_CONCAT(DISTINCT mgr.country_code SEPARATOR ', ') AS media_geo_restrict_codes,
                                    GROUP_CONCAT(DISTINCT ac.name SEPARATOR ', ') AS all_actors,
                                    GROUP_CONCAT(DISTINCT dir.name SEPARATOR ', ') AS all_directors,
                                    GROUP_CONCAT(DISTINCT prd.name SEPARATOR ', ') AS all_producers
            "))
            ->leftJoin('media_geo_restrict as mgr', 'm.id', 'mgr.media_id')
            ->leftJoin('movie_actors as ma', 'm.id', 'ma.movie_id')
            ->leftJoin('actors as ac', 'ma.actor_id', 'ac.id')
            ->leftJoin('movie_directors as md', 'm.id', 'md.movie_id')
            ->leftJoin('directors as dir', 'md.director_id', 'dir.id')
            ->leftJoin('movie_producers as mp', 'm.id', 'mp.movie_id')
            ->leftJoin('producers as prd', 'mp.producer_id', 'prd.id')
            ->where('m.batch_id', $id)
            ->groupBy('m.id')
            ->get();
    }
}
