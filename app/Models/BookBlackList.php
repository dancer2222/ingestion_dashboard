<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BookBlackList
 * @package App\Models
 */
class BookBlackList extends Model
{

    protected $table = 'book_blacklist';

    protected $fillable = ['book_id', 'status'];

    protected $primaryKey = 'book_id';

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getInfo()
    {
        return $this
            ->leftJoin('book', 'book_blacklist.book_id', '=', 'book.id')
            ->leftJoin('book_authors', 'book_blacklist.book_id', '=', 'book_authors.book_id')
            ->leftJoin('author', 'book_authors.author_id', '=', 'author.id')
            ->select([
                'book_blacklist.book_id',
                'book.title',
                'author.name',
                'book_blacklist.status',
                'book.source',
                'created_at',
                'updated_at'
            ])
            ->paginate(10);
    }

    /**
     * @param $id
     * @return \Illuminate\Support\Collection
     */
    public function getInfoById($id)
    {
        return $this
            ->where('book_blacklist.book_id', '=', $id)
            ->leftJoin('book', 'book_blacklist.book_id', '=', 'book.id')
            ->leftJoin('book_authors', 'book_blacklist.book_id', '=', 'book_authors.book_id')
            ->leftJoin('author', 'book_authors.author_id', '=', 'author.id')
            ->select([
                'book_blacklist.book_id',
                'book.title',
                'author.name',
                'book_blacklist.status',
                'book.source',
                'created_at',
                'updated_at'
            ])
            ->get();
    }
}
