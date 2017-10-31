<?php

namespace Ingestion\Search;

use App\Models\Album;
use App\Models\FailedItems;
use App\Models\Licensor;
use App\Models\DataSourceProvider;

/**
 * Class Albums
 * @package Ingestion\Reports
 */
class Albums
{
    /**
     * @param $id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function searchInfoById($id, $mediaTypeTitle, $country_code, $mediaGeoRestrictGetMediaType)
    {
        $licensor = new Licensor();
        try {
            $info = new Album();
            $info = $info->getById($id);
            $licensorName = $licensor->getNameLicensorById($info['licensor_id']);
            $idLink = substr($id, -7);
            $imageUrl = config('main.links.image.album') . $idLink . '.jpg';
        } catch (\Exception $exception) {
            $message = 'This [id] = ' . $id . '  not found in Albums database';
            return view('search.infoById', ['message' => $message]);
        }
        $providerName = new DataSourceProvider();
        $providerName = $providerName->getDataSourceProviderName($info['data_source_provider_id']);
        $failedItems = new FailedItems();
        $failedItems = $failedItems->getFailedItems($id, $info['batch_id']);

        $result = [
            'id'                           => $id,
            'country_code'                 => $country_code,
            'mediaTypeTitle'               => $mediaTypeTitle,
            'licensorName'                 => $licensorName,
            'info'                         => $info,
            'providerName'                 => $providerName,
            'imageUrl'                     => $imageUrl,
            'mediaGeoRestrictGetMediaType' => $mediaGeoRestrictGetMediaType,
            'messages'                     => $failedItems
        ];

        return $result;
    }
}