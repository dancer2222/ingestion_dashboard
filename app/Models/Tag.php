<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $connection = 'mysql_local_content';
    protected $table = 'tag';
    protected $fillable = ['name'];
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function audiobooks()
    {
        return $this->belongsToMany(
            Audiobook::class,
            'audio_book_tag',
            'tag_id',
            'audio_book_id',
            'id',
            'id'
        );
    }
}
