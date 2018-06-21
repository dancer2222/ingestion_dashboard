<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AudioBookBlackList
 * @package App\Models
 */
class AudioBookBlackList extends Model
{
    protected $table = 'audio_book_blacklist';

    protected $fillable = ['audio_book_id', 'status'];

    protected $primaryKey = 'audio_book_id';
}
