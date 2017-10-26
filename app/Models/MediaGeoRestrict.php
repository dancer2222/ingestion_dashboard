<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MediaGeoRestrict extends Model
{
    protected $table = 'media_geo_restrict';

    public function getAllGeoRestrictionInfo($id)
    {
        $allInfo = DB::table('media_geo_restrict')
            ->where('media_id', '=',$id)
            ->get();

        return count($allInfo) ? $allInfo : null;
    }

    public function getFirstGeoRestrictionInfo($id)
    {
        return DB::table('media_geo_restrict')
            ->select('media_type')
            ->where('media_id', '=',$id)->get()->first();
    }

    public function getGeoRestrictionInfoByMediaType($id, $mediaType)
    {
        $allInfo = DB::table('media_geo_restrict')
            ->where('media_id', '=',$id)
            ->where('media_type', '=', $mediaType)
            ->get();

        return count($allInfo) ? $allInfo : null;
    }
}
