<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Isbn\Isbn;

class BookLibrarythingData extends Model
{
    protected $connection = 'mysql_local_content';
    protected $table = 'book_librarything_datas';
    protected $fillable = ['isbn_10', 'workcode'];
    protected $primaryKey = 'isbn_10';
    public $timestamps = false;

    /**
     * Convert isbn_10 to string
     *
     * @param $isbn
     * @return string
     */
    public function getIsbn10Attribute($isbn): string
    {
        return "{$isbn}";
    }

    /**
     * Transform isbn10 to isbn13
     *
     * @return string
     */
    public function getIsbn13Attribute(): string
    {
        $isbnHelper = new Isbn();

        try {
            if ($isbnHelper->validation->isbn10($this->isbn_10)) {
                return $isbnHelper->translate->to13($this->isbn_10);
            }
        } catch (\Exception $e) {
            return '';
        }

        return '';
    }

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
