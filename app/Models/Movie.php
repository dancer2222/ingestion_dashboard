<?php

namespace App\Models;

use App\Models\Contracts\SearchableModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class Movie
 * @package App\Models
 */
class Movie extends Model implements SearchableModel
{
    /**
     * @var string
     */
    protected $table = 'movie';

    /**
     * @param $id
     * @return mixed
     */
    public function getInfoById($id)
    {
        return $this->where('id', $id)->get();
    }

    /**
     * @param $title
     * @return mixed
     */
    public function getInfoByTitle($title)
    {
        return $this->where('title', $title)->get();
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

    /**
     * @param $id
     * @return mixed
     */
    public function setStatus($id, $status)
    {
        $this->timestamps = false;

        return $this->where('id', $id)->update(['status' => $status]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function licensor()
    {
        return $this->belongsTo(Licensor::class, 'licensor_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function provider()
    {
        return $this->belongsToMany(
            DataSourceProvider::class,
            'qa_batches',
            'id',
            'data_source_provider_id',
            'batch_id',
            'id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function georestricts()
    {
        return $this->hasMany(MediaGeoRestrict::class, 'media_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function qaBatch()
    {
        return $this->belongsTo(QaBatch::class, 'batch_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brightcove()
    {
        return $this->belongsTo(Brightcove::class, 'id', 'id');
    }

    /**
     * @param string $needle
     * @param array $scopes
     * @return Builder
     */
    public function seek(string $needle, array $scopes = []): Builder
    {
        $isFound = false;
        $query = $this->newQuery();

        if ($scopes) {
            $query->with($scopes);
        }

        if (!$isFound && is_numeric($needle) && ctype_digit($needle)) {
            $query = $query->where('id', $needle)
                ->orWhere('data_origin_id', $needle);

            $isFound = true;
        }

        if (!$isFound) {
            $query->where('title', 'like', "%$needle%");
        }

        return $query;
    }

    /**
     * @param string $id
     * @param array $scopes
     * @return Builder|Model|null|object
     */
    public function seekById(string $id, array $scopes = [])
    {
        $query = $this->newQuery();

        if ($scopes) {
            $query->with($scopes);
        }

        return $query->where('id', $id)->first();
    }
}
