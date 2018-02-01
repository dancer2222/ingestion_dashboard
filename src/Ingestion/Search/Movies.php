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
class Movies
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
        $brightcove = new Brightcove();

        $info = new Movie();
        $info = $info->getInfoById($id);

        if ($info == null or $info->isEmpty() == true) {
            $message = 'This [id] = ' . $id . '  not found in Movies database';
            throw new \Exception($message);
        } elseif (count($info) == 1) {
            $info = $info[0];
        }
        //all info by batch_id
        $batchInfo = $qaBatches->getAllByBatchId($info->batch_id);
        $licensorName = $licensor->getNameLicensorById($info->licensor_id);
        $imageUrl = config('main.links.image.movie') . $id . '.jpg';
        $brightcove_id = $brightcove->getBrightcoveId($id);

        if ($brightcove_id != null) {
            $brightcove_id = $brightcove_id->brightcove_id;
        }

        if ($batchInfo != null && false != stristr($batchInfo['title'], '.')) {
            $providerName = new DataSourceProvider();
            $providerName = $providerName->getDataSourceProviderName($batchInfo['data_source_provider_id'])['name'];
            $batchInfo['title'] = explode($providerName . '_', $batchInfo['title'], 2)[1];

            // Create links to aws bucket
            $licensorNameToArray = Normalize::normalizeBucketName($licensorName);
            if ($licensorNameToArray != null) {
                $licensorName = $licensorNameToArray;
            }
            $linkCopy = config('main.links.aws.cp') . config('main.links.aws.bucket.movies') . '/' . $licensorName . '/' . $batchInfo['title'] . ' ./';
            $linkShow = config('main.links.aws.ls') . config('main.links.aws.bucket.movies') . '/' . $licensorName . '/' . $batchInfo['title'];
            // Create object for aws bucket
            $object = $licensorName . '/' . $batchInfo['title'];
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
            'brightcove_id'                => $brightcove_id
        ];

        return $result;
    }
}