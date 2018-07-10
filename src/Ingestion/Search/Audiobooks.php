<?php

namespace Ingestion\Search;

use App\Models\Audiobook;
use App\Models\AudiobookBlackList;
use App\Models\FailedItems;
use App\Models\Licensor;
use App\Models\QaBatch;
use App\Models\DataSourceProvider;

/**
 * Class Audiobooks
 * @package Ingestion\Reports
 */
class Audiobooks extends MediaTypeAbstract
{
    /**
     * @param $id
     * @param string $mediaTypeTitle
     * @param string $country_code
     * @param string $mediaGeoRestrictGetMediaType
     * @return array
     * @throws \Exception
     */
    public function searchInfoById(
        $id,
        string $mediaTypeTitle,
        $country_code,
        string $mediaGeoRestrictGetMediaType
    ): array {
        $qaBatches = new QaBatch();
        $licensor = new Licensor();
        $info = new Audiobook();

        $info = $info->getInfoById($id);
        $info = $this->toArray($info, $id, $mediaTypeTitle);

        $blackList = AudiobookBlackList::find($id);

        if (null == $blackList) {
            $blackListStatus = '';
        } else {
            $blackListStatus = $blackList->status;
        }

        //all info by batch_id
        $batchInfo = $qaBatches->getAllByBatchId($info['batch_id']);
        $licensorName = $licensor->getNameLicensorById($info['licensor_id']);
        $idLink = substr($id, -6);
        $imageUrl = config('main.links.image') . 'audiobook/findaway/square/' . $idLink . '.jpg';

        $providerName = new DataSourceProvider();
        $providerName = $providerName->getDataSourceProviderName($info['data_source_provider_id']);

        if ($batchInfo != null) {
            $failedItems = new FailedItems();
            $failedItems = $failedItems->getFailedItems($info['data_origin_id']);
        } else {
            $failedItems = null;
        }

        $result = [
            'id'                           => $id,
            'country_code'                 => $country_code,
            'mediaTypeTitle'               => $mediaTypeTitle,
            'batchInfo'                    => $batchInfo,
            'licensorName'                 => $licensorName,
            'info'                         => $info,
            'providerName'                 => $providerName,
            'imageUrl'                     => $imageUrl,
            'mediaGeoRestrictGetMediaType' => $mediaGeoRestrictGetMediaType,
            'messages'                     => $failedItems,
            'blackListStatus'              => $blackListStatus
        ];

        return $result;
    }
}