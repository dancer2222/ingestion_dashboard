<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Brightcove
 * @package App\Models
 */
class Brightcove extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $table = 'brightcove';

    /**
     * @var array
     */
    protected $fillable = ['id', 'brightcove_id', 'status', 'user_id', 'created_at', 'updated_at', 'non_drm_brightcove_id'];

    public function getBrightcoveId($id)
    {
        return $this->where('id',$id)
            ->select('brightcove_id')
            ->first();
    }
}
