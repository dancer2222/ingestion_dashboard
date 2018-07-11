<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class Audiobook
 * @package App\Models
 */
class Audiobook extends Model
{
    /**
     * @var string
     */
    protected $table = 'audio_book';

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
     *
     * @return mixed
     */
    public function getInfoByDataOriginId($id)
    {
        return $this->where('data_origin_id', $id)->get();
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
}
