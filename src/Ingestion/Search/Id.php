<?php
/**
 * Created by PhpStorm.
 * User: dancer
 * Date: 01.02.18
 * Time: 12:15
 */

namespace Ingestion\Search;

use App\Models\MediaGeoRestrict;

class Id
{
    public static function search($id)
    {
        $country_code = [];

        try {
            $mediaGeoRestrict = new MediaGeoRestrict();
            $mediaGeoRestrictInfo = $mediaGeoRestrict->getAllGeoRestrictionInfo($id);
        } catch (\Exception $exception) {
            return back()->with(['message' => $exception->getMessage()]);
        }

        //add in country_code status inactive
        if ($mediaGeoRestrictInfo !== null) {
            foreach ($mediaGeoRestrictInfo as &$item) {
                if ($item['status'] == 'inactive') {
                    $item['country_code'] = 'inactive';
                }
            }
        }

        //have more geo restrict info
        if (count($mediaGeoRestrictInfo) > 1) {

            foreach ($mediaGeoRestrictInfo as $value) {
                $country_code[] = $value['country_code'];
            }

            $country_codeUnique = array_unique($country_code);

            if (count($country_codeUnique) > 1) {
                foreach ($country_codeUnique as &$code) {
                    if ($code == 'inactive') {
                        $code = null;
                    }
                }
            }

        } else {

            if ($mediaGeoRestrictInfo === null) {
                $country_codeUnique [] = 'This [id] = ' . $id . '  not found in mediaGeoRestrict';
            } else {
                $country_codeUnique [] = $mediaGeoRestrictInfo[0]['country_code'];
            }
        }

        return $country_codeUnique;
    }
}