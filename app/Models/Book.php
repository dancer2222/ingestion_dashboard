<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class Book
 * @package App\Models
 */
class Book extends Model
{
    /**
     * @var string
     */
    protected $table = 'book';

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
}
