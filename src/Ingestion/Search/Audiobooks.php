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
        $audiobook = Audiobook::where('id', $id)->with('products')->first();
        $info = $audiobook->toArray();

        $blackList = AudiobookBlackList::find($id);

        if (null == $blackList) {
            $blackListStatus = '';
        } else {
            $blackListStatus = $blackList->status;
        }

        //all info by batch_id
        $batchInfo = $qaBatches->getAllByBatchId($info['batch_id']);

        if ($licensor->getNameLicensorById($info['licensor_id'])) {
            $licensorName = $licensor->getNameLicensorById($info['licensor_id'])->name;
        }

        $idLink = substr($id, -6);
        $imageUrl = config('main.links.image') . 'audiobook/findaway/square/' . $idLink . '.jpg';

        $dataSourceProvider = new DataSourceProvider();

        if ($dataSourceProvider->getDataSourceProviderName($info['data_source_provider_id'])) {
            $providerName = $dataSourceProvider->getDataSourceProviderName($info['data_source_provider_id'])->name;
        }

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
            'blackListStatus'              => $blackListStatus,
            'products'                     => $info['products'],
        ];

        return $result;
    }
}