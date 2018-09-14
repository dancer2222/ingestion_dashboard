<?php

namespace App\Models;

use App\Models\Contracts\SearchableModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Isbn\Isbn;

/**
 * Class Book
 * @package App\Models
 */
class Book extends Model implements SearchableModel
{
    /**
     * @var string
     */
    protected $table = 'book';
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
     * @param $isbn
     *
     * @return mixed
     */
    public function getInfoByIsbn($isbn)
    {
        return $this->where('isbn', $isbn)->get();
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
    public function getBatchInfoForBooks($id)
    {
        return DB::table('book as b')
            ->select(DB::raw("
                                b.id,
                                GROUP_CONCAT(DISTINCT b.data_origin_id SEPARATOR ', ') AS ISBN,
                                GROUP_CONCAT(DISTINCT b.title SEPARATOR ', ') AS title,
                                GROUP_CONCAT(DISTINCT b.date_added SEPARATOR ', ') AS date_added,
                                GROUP_CONCAT(DISTINCT b.ma_release_date SEPARATOR ', ') AS ma_release_date,
                                GROUP_CONCAT(DISTINCT b.status SEPARATOR ', ') AS status,
                                GROUP_CONCAT(DISTINCT b.source SEPARATOR ', ') AS source,
                                GROUP_CONCAT(DISTINCT b.description SEPARATOR ', ') AS description,
                                GROUP_CONCAT(DISTINCT b.date_published SEPARATOR ', ') AS date_published,
                                GROUP_CONCAT(DISTINCT b.premium SEPARATOR ', ') AS premium,
                                GROUP_CONCAT(DISTINCT b.number_of_pages SEPARATOR ', ') AS number_of_pages,
                                GROUP_CONCAT(DISTINCT artist.name SEPARATOR ', ') AS artist_name,
                                GROUP_CONCAT(DISTINCT auth.name SEPARATOR ', ') AS auth_name,
                                GROUP_CONCAT(DISTINCT licen.name SEPARATOR ', ') AS licensor_name,
                                GROUP_CONCAT(DISTINCT l.name SEPARATOR ', ') AS language
            "))
            ->leftJoin('book_artists as bart', 'b.id', 'bart.book_id')
            ->leftJoin('artists as artist', 'bart.artist_id', 'artist.id')
            ->leftJoin('book_authors as bauth', 'b.id', 'bauth.book_id')
            ->leftJoin('author as auth', 'bauth.author_id', 'auth.id')
            ->leftJoin('licensors as licen', 'b.licensor_id', 'licen.id')
            ->leftJoin('media_language as ml', 'ml.media_id', 'b.id')
            ->leftJoin('ma_language as l', 'l.id', 'ml.language_id')
            ->where('b.batch_id', $id)
            ->groupBy('b.id')
            ->get();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function setStatusInactiveInBook($id)
    {
        $this->timestamps = false;

        return $this->where('id', $id)->update(['status' => 'inactive']);
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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|mixed
     */
    public function rating(): HasOne
    {
        return $this->hasOne(BookAverageRatingLT::class, 'book_id', 'id');
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
        return $this->belongsTo(DataSourceProvider::class, 'source', 'name');
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
        return $this->hasOne(BookBlackList::class, 'book_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function languages()
    {
        return $this->belongsToMany(
            MaLanguage::class,
            'media_language',
            'media_id',
            'language_id',
            'id',
            'id'
            );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function qaBatch()
    {
        return $this->belongsTo(QaBatch::class, 'batch_id');
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

        if (!$isFound && is_numeric($needle) && ctype_digit($needle)) {
            $query = $query->where('id', $needle)
                ->orWhere('data_origin_id', $needle);

            $isFound = true;
        }

        if (!$isFound) {
            $query->where('title', 'like', "%$needle%");

            $isFound = true;
        }

        if (!$isFound && $isbnHandler->validation->isbn($needle)) {
            $isbn = $isbnHandler->hyphens->removeHyphens($needle);
            $query->where('isbn', $isbn);
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
