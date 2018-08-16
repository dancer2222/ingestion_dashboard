<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookAverageRatingLT extends Model
{
    protected $connection = 'mysql_local_content';
    protected $table = 'book_average_ratings_lt';
    protected $fillable = ['book_id', 'rating', 'votes_total'];
    public $timestamps = false;
}
