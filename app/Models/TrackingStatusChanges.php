<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TrackingStatusChanges
 * @package App\Models
 */
class TrackingStatusChanges extends Model
{
    /**
     * @var string
     */
    protected $table = 'tracking_status_changes';

    /**
     * @param $id
     * @return mixed
     */
    public function getInfoById($id)
    {
       return $this->where('media_id', $id)->get();
    }
}
