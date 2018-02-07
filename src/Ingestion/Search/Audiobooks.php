<?php

namespace Ingestion\Search;

use App\Models\Audiobook;
use App\Models\FailedItems;
use App\Models\Licensor;
use App\Models\QaBatch;
use App\Models\DataSourceProvider;

/**
 * Class Audiobooks
 * @package Ingestion\Reports
 */
class Audiobooks
{
    /**
     * @param $id
     * @param $mediaTypeTitle
     * @param $country_code
     * @param $mediaGeoRestrictGetMediaType
     *
     * @return array
     * @throws \Exception
     */
    public static function searchInfoById($id, $mediaTypeTitle, $country_code, $mediaGeoRestrictGetMediaType)
    {
        $qaBatches = new QaBatch();
        $licensor = new Licensor();
        $info = new Audiobook();
        $info = $info->getInfoById($id);

        if ($info->isEmpty()) {

            $message = 'This [id] = ' . $id . '  not found in Audiobooks database';

            throw new \Exception($message);
        } elseif (count($info) == 1) {
            $info = $info[0];
        }

        //all info by batch_id
        $batchInfo = $qaBatches->getAllByBatchId($info->batch_id);
        $licensorName = $licensor->getNameLicensorById($info->licensor_id);
        $idLink = substr($id, -6);
        $imageUrl = config('main.links.image.audiobook') . $idLink . '.jpg';

        $providerName = new DataSourceProvider();
        $providerName = $providerName->getDataSourceProviderName($info->data_source_provider_id)['name'];
        if ($batchInfo != null) {
            $failedItems = new FailedItems();
            $failedItems = $failedItems->getFailedItems($id);
        } else {
            $failedItems = null;
        }

        $result = [
            'id' => $id,
            'country_code' => $country_code,
            'mediaTypeTitle' => $mediaTypeTitle,
            'batchInfo' => $batchInfo,
            'licensorName' => $licensorName,
            'info' => $info,
            'providerName' => $providerName,
            'imageUrl' => $imageUrl,
            'mediaGeoRestrictGetMediaType' => $mediaGeoRestrictGetMediaType,
            'messages' => $failedItems
        ];

        return $result;
    }
}