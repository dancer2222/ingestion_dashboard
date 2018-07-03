<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class AudiobookProduct
 * @package App\Models
 */
class AudiobookProduct extends Model
{
    /**
     * @var string
     */
    protected $table = 'audio_book_products';

    /**
     * @param $isbn
     * @return mixed
     */
    public static function getIdByIsbn($isbn)
    {
        return  DB::table('audio_book_products as abp')
            ->select('audio_book_id')
            ->leftJoin('product_audio_book as pab', 'abp.product_id', 'pab.id')
            ->where('pab.isbn', $isbn)
            ->first();
    }
}
