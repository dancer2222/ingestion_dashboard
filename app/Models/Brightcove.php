<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brightcove extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $table = 'brightcove';

    protected $fillable = ['id', 'brightcove_id', 'status', 'user_id', 'created_at', 'updated_at', 'non_drm_brightcove_id'];
}
