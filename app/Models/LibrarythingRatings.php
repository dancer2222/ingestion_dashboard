<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LibrarythingRatings extends Model
{
    protected $connection = 'mysql_local_content';
    protected $table = 'librarything_ratings';
    protected $fillable = ['workcode', 'rating', 'count'];
    protected $primaryKey = 'workcode';
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function workcodes()
    {
        return $this->hasMany(BookLibrarythingData::class, 'workcode', 'workcode');
    }
}
