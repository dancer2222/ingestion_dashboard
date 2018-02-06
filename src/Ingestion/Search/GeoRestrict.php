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
    public static function search($id)
    {
        $mediaGeoRestrict = new MediaGeoRestrict();
        $mediaGeoRestrictInfo = $mediaGeoRestrict->getAllGeoRestrictionInfo($id);

        if ($mediaGeoRestrictInfo->isEmpty() == true) {
            $countryCode [] = 'This [id] = ' . $id . '  not found in mediaGeoRestrict';
        } else {
            foreach ($mediaGeoRestrictInfo as $item) {
                $countryCode []= $item->toArray();
            }
        }

        return $countryCode;
    }
}