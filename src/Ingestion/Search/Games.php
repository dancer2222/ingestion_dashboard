<?php
/**
 * Created by PhpStorm.
 * User: dancer
 * Date: 25.10.17
 * Time: 19:56
 */

namespace Ingestion\Search;

use App\Models\Game;
use App\Models\Licensor;

/**
 * Class Games
 * @package Ingestion\Reports
 */
class Games
{
    /**
     * @param $id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function searchInfoById($id, $mediaTypeTitle, $country_code, $mediaGeoRestrictGetMediaType)
    {
        $licensor = new Licensor();
        try {
            $info = new Game();
            $info = $info->getById($id)[0];
            $imageUrl = config('main.links.image.game') . $id . '.jpg';
        } catch (\Exception $exception) {
            $message = 'This [id] = ' . $id . '  not found in Games database';
            return view('search.infoById', ['message' => $message]);
        }
        $licensorName = $licensor->getNameLicensorById($info->licensor_id)[0]->name;

        $result = [
            'id'                           => $id,
            'country_code'                 => $country_code,
            'mediaTypeTitle'               => $mediaTypeTitle,
            'licensorName'                 => $licensorName,
            'info'                         => (array)$info,
            'imageUrl'                     => $imageUrl,
            'mediaGeoRestrictGetMediaType' => $mediaGeoRestrictGetMediaType
        ];

        return $result;
    }
}