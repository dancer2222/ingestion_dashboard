<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookLibrarythingData extends Model
{
    protected $connection = 'mysql_local_content';
    protected $table = 'book_librarything_datas';
    protected $fillable = ['isbn_10', 'workcode'];
    protected $primaryKey = 'isbn_10';
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tags()
    {
        return $this->hasMany(LibrarythingTag::class, 'workcode', 'workcode');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ratings()
    {
        return $this->hasMany(LibrarythingRatings::class, 'workcode', 'workcode');
    }
}
