<?php
/**
 * Created by PhpStorm.
 * User: dancer
 * Date: 25.10.17
 * Time: 19:01
 */

namespace Ingestion\Search;

use App\Models\DataSourceProvider;
use App\Http\Controllers\SearchController;
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
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function searchInfoById($id, $mediaTypeTitle, $country_code, $mediaGeoRestrictGetMediaType)
    {
        $qaBatches = new QaBatch();
        $licensor = new Licensor();
        try {
            $info = new Movie();
            $info = $info->getById($id)[0];
            //all info by batch_id
            $batchInfo = $qaBatches->getAllByBatchId($info->batch_id)[0];
            $licensorName = $licensor->getNameLicensorById($info->licensor_id)[0]->name;
            $imageUrl = config('main.links.image.movie') . $id . '.jpg';
        } catch (\Exception $exception) {
            $message = 'This [id] = ' . $id . '  not found in Movies database';
            return view('search.infoById', ['message' => $message]);
        }
        if ($batchInfo != null && false != stristr($batchInfo->title, '.')) {
            $providerName = new DataSourceProvider();
            $providerName = $providerName->getDataSourceProviderName($batchInfo->data_source_provider_id)[0]->name;
            $batchInfo->title = explode($providerName . '_', $batchInfo->title, 2)[1];

            // Create links to aws bucket
            $licensorNameToArray = SearchController::normalizeBucketName($licensorName);
            if ($licensorNameToArray != null) {
                $licensorName = $licensorNameToArray;
            }
            $linkCopy = config('main.links.aws.cp') . config('main.links.aws.bucket.movies') . '/' . $licensorName . '/' . $batchInfo->title . ' ./';
            $linkShow = config('main.links.aws.ls') . config('main.links.aws.bucket.movies') . '/' . $licensorName . '/' . $batchInfo->title;
            // Create object for aws bucket
            $object = $licensorName . '/' . $batchInfo->title;
        } else {
            $linkCopy = null;
            $linkShow = null;
            $object = null;
            $batchInfo = null;
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
            'info'                         => (array)$info,
            'imageUrl'                     => $imageUrl,
            'mediaGeoRestrictGetMediaType' => $mediaGeoRestrictGetMediaType
        ];

        return $result;
    }
}