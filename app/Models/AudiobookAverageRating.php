<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AudiobookAverageRating extends Model
{
    protected $connection = 'mysql_local_content';
    protected $table = 'audio_book_average_ratings_lt';
    protected $fillable = ['audiobook_id', 'rating', 'votes_total'];
    public $timestamps = false;
}
