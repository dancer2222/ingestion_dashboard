<?php

namespace Ingestion\Search;

use App\Models\Brightcove;
use App\Models\DataSourceProvider;
use App\Models\FailedItems;
use App\Models\Licensor;
use App\Models\Movie;
use App\Models\QaBatch;

/**
 * Class Movies
 * @package Ingestion\Reports
 */
class Movies extends MediaTypeAbstract
{
    /**
     * @param $id
     * @param string $mediaTypeTitle
     * @param string $country_code
     * @param string $mediaGeoRestrictGetMediaType
     * @return array
     * @throws \Exception
     */
    public function searchInfoById($id, string $mediaTypeTitle, $country_code, string $mediaGeoRestrictGetMediaType) : array
    {
        $qaBatches = new QaBatch();
        $licensor = new Licensor();
        $brightcove = new Brightcove();
        $info = new Movie();

        $info = $info->getInfoById($id);
        $info = $this->toArray($info, $id, $mediaTypeTitle);

        //all info by batch_id
        $batchInfo = $qaBatches->getAllByBatchId($info['batch_id']);
        $licensorName = $licensor->getNameLicensorById($info['licensor_id']);
        $imageUrl = config('main.links.image') . 'movie/' . $id . '.jpg';
        $brightcove_id = $brightcove->getBrightcoveId($id);

        if (!$brightcove_id->isEmpty()) {
            $brightcove_id = $brightcove_id[0]->toArray()['brightcove_id'];
        }

        if ($batchInfo != null && false != stristr($batchInfo['title'], '.')) {
            $providerName = new DataSourceProvider();
            $providerName = $providerName->getDataSourceProviderName($batchInfo['data_source_provider_id']);
            $batchInfo['title'] = explode($providerName . '_', $batchInfo['title'], 2)[1];

            // Create links to aws bucket
            $licensorNameToArray = Normalize::normalizeBucketName($licensorName);
            if ($licensorNameToArray != null) {
                $licensorNameByBucket = $licensorNameToArray;
            }
            $linkCopy = config('main.links.aws.cp') . config('main.links.aws.bucket.movies') . '/' . $licensorNameByBucket . '/' . $batchInfo['title'] . ' ./';
            $linkShow = config('main.links.aws.ls') . config('main.links.aws.bucket.movies') . '/' . $licensorNameByBucket . '/' . $batchInfo['title'];

            // Create object for aws bucket
            $object = $licensorNameByBucket . '/' . $batchInfo['title'];
            $failedItems = new FailedItems();
            $failedItems = $failedItems->getFailedItems($id);
        } else {
            $linkCopy = null;
            $linkShow = null;
            $object = null;
            $batchInfo = null;
            $failedItems = null;
        }

        $result = [
            'id'                           => $id,
            'country_code'                 => $country_code,
            'mediaTypeTitle'               => $mediaTypeTitle,
            'linkCopy'                     => $linkCopy,
            'linkShow'                     => $linkShow,
            'object'                       => $object,
            'batchInfo'                    => $batchInfo,
            'licensorName'                 => $licensorName,
            'info'                         => $info,
            'imageUrl'                     => $imageUrl,
            'mediaGeoRestrictGetMediaType' => $mediaGeoRestrictGetMediaType,
            'messages'                     => $failedItems,
            'brightcove_id'                => $brightcove_id,
            'blackListStatus'              => ''
        ];

        return $result;
    }
}