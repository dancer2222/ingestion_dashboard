<?php

namespace Ingestion\Search;

use App\Models\AudioBook;
use App\Models\Licensor;
use App\Models\QaBatch;
use App\Models\DataSourceProvider;

/**
 * Class AudioBooks
 * @package Ingestion\Reports
 */
class AudioBooks
{
    /**
     * @param $id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function searchInfoById($id, $mediaTypeTitle, $country_code, $mediaGeoRestrictGetMediaType)
    {
        $qaBatches = new QaBatch();
        $licensor = new Licensor();
        try {
            $info = new AudioBook();
            $info = $info->getById($id)[0];
            //all info by batch_id
            $batchInfo = $qaBatches->getAllByBatchId($info->batch_id)[0];
            $licensorName = $licensor->getNameLicensorById($info->licensor_id)[0]->name;
            $idLink = substr($id, -5);
            $imageUrl = config('main.links.image.audiobook') . $idLink . '.jpg';
        } catch (\Exception $exception) {
            $message = 'This [id] = ' . $id . '  not found in AudioBooks database';
            return view('search.infoById', ['message' => $message]);
        }
        $providerName = new DataSourceProvider();
        $providerName = $providerName->getDataSourceProviderName($info->data_source_provider_id)[0]->name;

        $result = [
            'id'                           => $id,
            'country_code'                 => $country_code,
            'mediaTypeTitle'               => $mediaTypeTitle,
            'batchInfo'                    => $batchInfo,
            'licensorName'                 => $licensorName,
            'info'                         => (array)$info,
            'providerName'                 => $providerName,
            'imageUrl'                     => $imageUrl,
            'mediaGeoRestrictGetMediaType' => $mediaGeoRestrictGetMediaType
        ];

        return $result;
    }
}