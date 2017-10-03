<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MediaGeoRestrict extends Model
{
    protected $table = 'media_geo_restrict';

    public function getAllGeoRestrictionInfo($id)
    {
        return $allInfo = DB::table('media_geo_restrict')
            ->where('media_id', '=',$id)->get();
    }

    public function getFirstGeoRestrictionInfo($id)
    {
        return $allInfo = DB::table('media_geo_restrict')
            ->select('media_type')
            ->where('media_id', '=',$id)->get()->first();
    }

    public function getGeoRestrictionInfoByMediaType($id, $mediaType)
    {
        $allInfo = DB::table('media_geo_restrict')
            ->where('media_id', '=',$id)
            ->where('media_type', '=', $mediaType)
            ->get();

        if (count($allInfo) == 0) {
            return $allInfo = null;
        } else {
            return $allInfo;
        }
    }
}
