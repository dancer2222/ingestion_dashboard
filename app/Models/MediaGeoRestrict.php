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
        $allInfo = DB::table('media_geo_restrict')
            ->where('media_id', '=', $id)
            ->get();

        return count($allInfo) ? $allInfo : null;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getFirstGeoRestrictionInfo($id)
    {
        return DB::table('media_geo_restrict')
            ->select('media_type')
            ->where('media_id', '=', $id)->get()->first();
    }

    /**
     * @param $id
     * @param $mediaType
     * @return null
     */
    public function getGeoRestrictionInfoByMediaType($id, $mediaType)
    {
        $allInfo = DB::table('media_geo_restrict')
            ->where('media_id', '=', $id)
            ->where('media_type', '=', $mediaType)
            ->get();

        return count($allInfo) ? $allInfo : null;
    }
}