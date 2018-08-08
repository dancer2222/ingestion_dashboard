<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AudiobookAverageRating extends Model
{
    protected $connection = 'mysql_local_content';
    protected $table = 'audio_book_average_ratings';
    protected $fillable = ['audiobook_id', 'rating_lt', 'votes_total_lt'];
    public $timestamps = false;
}
