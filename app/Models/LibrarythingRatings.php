<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LibrarythingRatings extends Model
{
    protected $connection = 'mysql_local_content';
    protected $table = 'librarything_ratings';
    protected $fillable = ['workcode', 'rating', 'count'];
    public $timestamps = false;
}
