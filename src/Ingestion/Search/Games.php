<?php

namespace Ingestion\Search;

use App\Models\Game;
use App\Models\Licensor;

/**
 * Class Games
 * @package Ingestion\Search
 */
class Games extends MediaTypeAbstract
{
    /**
     * @param $id
     * @param string $mediaTypeTitle
     * @param string $country_code
     * @param string $mediaGeoRestrictGetMediaType
     * @return array
     */
    public function searchInfoById($id, string $mediaTypeTitle, $country_code, string $mediaGeoRestrictGetMediaType) : array
    {
        $licensor = new Licensor();
        try {
            $info = new Game();
            $info = $info->getInfoById($id);
            $info = $this->toArray($info, $id, $mediaTypeTitle);
            $imageUrl = config('main.links.image') . 'game/' . $id . '.jpg';
        } catch (\Exception $exception) {
            $message = 'This [id] = ' . $id . '  not found in Games database';
            return view('search.infoById', ['message' => $message]);
        }
        $licensorName = $licensor->getNameLicensorById($info['licensor_id']);

        $result = [
            'id'                           => $id,
            'country_code'                 => $country_code,
            'mediaTypeTitle'               => $mediaTypeTitle,
            'licensorName'                 => $licensorName,
            'info'                         => $info,
            'imageUrl'                     => $imageUrl,
            'mediaGeoRestrictGetMediaType' => $mediaGeoRestrictGetMediaType
        ];

        return $result;
    }
}