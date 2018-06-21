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

    protected $primaryKey = 'audio_book_id';
}
