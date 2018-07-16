<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AudiobookBlackList
 * @package App\Models
 */
class AudiobookBlackList extends Model
{
    protected $table = 'audio_book_blacklist';

    protected $fillable = ['audio_book_id', 'status'];

    protected $primaryKey = 'audio_book_id';

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getInfo($paginate)
    {
        return $this
            ->leftJoin('audio_book', 'audio_book_blacklist.audio_book_id', '=',
            'audio_book.id')
            ->leftJoin('audio_book_authors', 'audio_book_blacklist.audio_book_id', '=',
            'audio_book_authors.audio_book_id')
            ->leftJoin('author_audio_book',
            'audio_book_authors.author_id', '=', 'author_audio_book.id')
            ->select([
            'audio_book_blacklist.audio_book_id',
            'audio_book.title',
            'author_audio_book.name',
            'audio_book_blacklist.status',
            'audio_book.data_source_provider_id',
            'created_at',
            'updated_at'
        ])->paginate($paginate);
    }

    public function getInfoById($id)
    {
        return $this
            ->where('audio_book_blacklist.audio_book_id', '=', $id)
            ->leftJoin('audio_book',
            'audio_book_blacklist.audio_book_id', '=', 'audio_book.id')
            ->leftJoin('audio_book_authors',
            'audio_book_blacklist.audio_book_id', '=',
            'audio_book_authors.audio_book_id')
            ->leftJoin('author_audio_book',
            'audio_book_authors.author_id', '=', 'author_audio_book.id')
            ->select([
            'audio_book_blacklist.audio_book_id',
            'audio_book.title',
            'author_audio_book.name',
            'audio_book_blacklist.status',
            'audio_book.data_source_provider_id',
            'created_at',
            'updated_at'
        ])->get();
    }
}
