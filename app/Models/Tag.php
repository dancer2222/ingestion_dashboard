<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $connection = 'mysql_local_content';
    protected $table = 'tag';
    protected $fillable = ['name', 'slug'];
    public $timestamps = false;
}
