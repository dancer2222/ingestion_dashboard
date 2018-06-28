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
}
