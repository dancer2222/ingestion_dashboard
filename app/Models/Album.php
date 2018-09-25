<?php

namespace App\Models;

use App\Models\Contracts\SearchableModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

/**
 * Class Album
 * @package App\Models
 */
class Album extends Model implements SearchableModel
{
    /**
     * @var string
     */
    protected $table = 'music_album';
    public $timestamps = false;

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
     * @param $upc
     *
     * @return mixed
     */
    public function getInfoByUpc($upc)
    {
        return $this->where('upc', $upc)->get();
    }

    /**
     * @param $dataOriginId
     * @return mixed
     */
    public function getInfoByDataOriginId($dataOriginId)
    {
        return $this->where('data_origin_id', $dataOriginId)->get();
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function statusChanges()
    {
        return $this->hasMany(TrackingStatusChanges::class, 'media_id', 'id');
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
    public function licensor()
    {
        return $this->belongsTo(Licensor::class, 'licensor_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function provider()
    {
        return $this->belongsTo(DataSourceProvider::class, 'data_source_provider_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function georestricts()
    {
        return $this->hasMany(MediaGeoRestrict::class, 'media_id', 'id');
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function failedItems()
    {
        return $this->hasMany(FailedItems::class, 'item_id', 'data_origin_id');
    }

    /**
     * @param string $needle
     * @param array $scopes
     * @param array $has
     * @return Builder
     */
    public function seek(string $needle, array $scopes = [], array $has = []): Builder
    {
        $isFound = false;
        $query = $this->newQuery();

        if ($has) {
            foreach ($has as $hasItem) {
                if ($hasItem) {
                    $query->has($hasItem);
                }
            }
        }

        if ($scopes) {
            $query->with($scopes);
        }

        $trimmed = str_replace(['-', ' ', '`', '\''], '', $needle);

        if (is_numeric($trimmed) && ctype_digit($trimmed)) {
            $query = $query->where('id', 'like', "%$trimmed%")
                ->orWhere('data_origin_id', 'like', "%$trimmed%")
                ->orWhere('upc', 'like', "%$trimmed%")
                ->orWhere('batch_id', 'like', "%$trimmed%");

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
     * @param array $has
     * @return Builder|Model|null|object
     */
    public function seekById(string $id, array $scopes = [], array $has = [])
    {
        $query = $this->newQuery();

        if ($has) {
            foreach ($has as $hasItem) {
                if ($hasItem) {
                    $query->has($hasItem);
                }
            }
        }

        if ($scopes) {
            $query->with($scopes);
        }

        return $query->where('id', $id)->first();
    }
}
