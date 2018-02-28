<?php

namespace Ingestion\Search;

use App\Models\MediaGeoRestrict;

/**
 * Class GeoRestrict
 * @package Ingestion\Search
 */
class GeoRestrict
{
    /**
     * @param $id
     * @return array
     */
    public static function search($id) : array
    {
        $mediaGeoRestrict = new MediaGeoRestrict();
        $mediaGeoRestrictInfo = $mediaGeoRestrict->getAllGeoRestrictionInfo($id);
        $countryCode = [];

        if ($mediaGeoRestrictInfo->isEmpty()) {
            $countryCode [] = 'This [id] = ' . $id . '  not found in mediaGeoRestrict';
        } else {
            foreach ($mediaGeoRestrictInfo as $item) {
                $countryCode []= $item->toArray();
            }
        }

        return $countryCode;
    }
}