<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class MediaGeoRestrict
 * @package App\Models
 */
class MediaGeoRestrict extends Model
{
    /**
     * @var string
     */
    protected $table = 'media_geo_restrict';

    /**
     * @param $id
     * @return null
     */
    public function getAllGeoRestrictionInfo($id)
    {
        $allInfo = $this->where('media_id', $id)
            ->get()->toArray();

        return count($allInfo) ? $allInfo : null;
    }
}
