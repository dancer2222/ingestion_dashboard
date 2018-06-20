<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AudioBookBlackList extends Model
{
    protected $table = 'audio_book_blacklist';

    protected $fillable = ['audio_book_id', 'status'];

}
