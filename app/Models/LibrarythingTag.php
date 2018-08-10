<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LibrarythingTag extends Model
{
    protected $connection = 'mysql_local_content';
    protected $table = 'librarything_tags';
    protected $fillable = ['workcode', 'tag_id', 'weight'];
    public $timestamps = false;
}
