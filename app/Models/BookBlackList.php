<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookBlackList extends Model
{
    protected $table = 'book_blacklist';

    protected $fillable = ['book_id', 'status'];
}
