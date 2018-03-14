<?php

namespace Ingestion\Search;

use App\Models\MediaGeoRestrict;
use App\Models\MediaType;

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
    public static function search($id, $type) : array
    {
        $mediaGeoRestrict = new MediaGeoRestrict();
        $mediaGeoRestrictInfo = $mediaGeoRestrict->getAllGeoRestrictionInfo($id, MediaType::getIdByTitle($type));
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