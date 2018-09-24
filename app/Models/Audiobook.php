<?php

namespace App\Models;

use App\Models\Contracts\SearchableModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Isbn\Isbn;

/**
 * Class Audiobook
 * @package App\Models
 */
class Audiobook extends Model implements SearchableModel
{
    /**
     * @var string
     */
    protected $table = 'audio_book';
    protected $connection = 'mysql_local_content';
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
     * @param $dataOriginId
     * @return mixed
     */
    public function getInfoByDataOriginId($dataOriginId)
    {
        return $this->where('data_origin_id', $dataOriginId)->get();
    }

    /**
     * @param $isbn
     * @return mixed
     */
    public function getInfoByIsbn($isbn)
    {
        $result = AudiobookProduct::getIdByIsbn($isbn);

        if ($result) {
            return $this->where('id', $result->audio_book_id)->get();
        }

        return [];
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getBatchInfoForAudioBooks($id)
    {
        return DB::table('audio_book as ab')
            ->select(DB::raw("
                GROUP_CONCAT(DISTINCT ab.id SEPARATOR ', ') AS id,
                GROUP_CONCAT(DISTINCT ab.title SEPARATOR ', ') AS title,
                GROUP_CONCAT(DISTINCT ab.description SEPARATOR', ') AS description,
                GROUP_CONCAT(DISTINCT ab.data_origin_id SEPARATOR ', ') AS data_origin_id,
                GROUP_CONCAT(DISTINCT ab.date_added SEPARATOR ', ') AS date_added,
                GROUP_CONCAT(DISTINCT ab.img_url SEPARATOR ', ') AS img_url,
                GROUP_CONCAT(DISTINCT ab.abridgment SEPARATOR ', ') AS abridgment,
                GROUP_CONCAT(DISTINCT ab.size_in_bytes SEPARATOR ', ') AS size_in_bytes,
                GROUP_CONCAT(DISTINCT ab.runtime SEPARATOR ', ') AS runtime,
                GROUP_CONCAT(DISTINCT ab.duration SEPARATOR ', ') AS duration,
                GROUP_CONCAT(DISTINCT ab.copyright_year SEPARATOR ', ') AS copyright_year,
                GROUP_CONCAT(DISTINCT ab.sample_url SEPARATOR ', ') AS sample_url,
                GROUP_CONCAT(DISTINCT ab.grade_level SEPARATOR ', ') AS grade_level,
                GROUP_CONCAT(DISTINCT ab.title_acquisition_status SEPARATOR ', ') AS title_acquisition_status,
                GROUP_CONCAT(DISTINCT ab.status SEPARATOR ', ') AS status,
                GROUP_CONCAT(DISTINCT ab.date_published SEPARATOR ', ') AS date_published,
                GROUP_CONCAT(DISTINCT ab.ma_release_date SEPARATOR ', ') AS ma_release_date,
                GROUP_CONCAT(DISTINCT ab.average_rating SEPARATOR ', ') AS average_rating,
                GROUP_CONCAT(DISTINCT ab.premium SEPARATOR ', ') AS premium,
                GROUP_CONCAT(DISTINCT ab.modified_date SEPARATOR ', ') AS modified_date,
                GROUP_CONCAT(DISTINCT licen.name SEPARATOR ', ') AS licensor_name
            "))
            ->leftJoin('licensors as licen', 'ab.licensor_id', 'licen.id')
            ->where('ab.batch_id', $id)
            ->groupBy('ab.id')
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'audio_book_tag',
            'audio_book_id',
            'tag_id',
            'id',
            'id'
        )->withPivot(['id']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(
            ProductAudioBook::class,
            'audio_book_products',
            'audio_book_id',
            'product_id',
            'id',
            'id'
        )->withPivot('subscription_type');
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function statusChanges()
    {
        return $this->hasMany(TrackingStatusChanges::class, 'media_id', 'id');
    }

    /**
     * @return HasOne
     */
    public function blacklist()
    {
        return $this->hasOne(AudiobookBlackList::class, 'audio_book_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|mixed
     */
    public function rating(): HasOne
    {
        return $this->hasOne(AudiobookAverageRating::class, 'audiobook_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function qaBatch()
    {
        return $this->belongsTo(QaBatch::class, 'batch_id');
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
     * @throws \Isbn\Exception
     */
    public function seek(string $needle, array $scopes = [], array $has = []): Builder
    {
        $isFound = false;
        $isbnHandler = new Isbn();
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

        $trimmed = str_replace(['-', ' '], '', $needle);

        if ($isbnHandler->validation->isbn($needle)) {
            $isbn = $isbnHandler->hyphens->removeHyphens($needle);
            $query->whereHas('products', function ($query) use ($isbn) {
                $query->where('isbn', $isbn);
            });

            $isFound = true;
        }

        if (!$isFound && is_numeric($trimmed) && ctype_digit($trimmed)) {
            $query->where('id', $trimmed)
                ->orWhere('data_origin_id', $trimmed);

            $isFound = true;
        }

        if (!$isFound) {
            $query->where('title', 'like', "%$needle%");
        }

        $query->select(['id', 'title', 'licensor_id']);

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

        $query->select([
            'id', 'licensor_id', 'data_source_provider_id', 'data_origin_id', 'title', 'description', 'grade_level',
            'street_date', 'status', 'batch_id', 'date_published', 'ma_release_date', 'premium', 'date_added',
        ]);

        return $query->where('id', $id)->first();
    }
}
