<?php
/**
 * Created by PhpStorm.
 * User: dancer
 * Date: 25.10.17
 * Time: 19:34
 */

namespace Ingestion\Search;

use App\Http\Controllers\SearchController;
use App\Models\Book;
use App\Models\Licensor;
use App\Models\QaBatch;

/**
 * Class Books
 * @package Ingestion\Reports
 */
class Books
{
    /**
     * @param $id
     * @return array
     */
    public static function searchInfoById($id, $mediaTypeTitle, $country_code, $mediaGeoRestrictGetMediaType)
    {
        $qaBatches = new QaBatch();
        $licensor = new Licensor();
        try {
            $info = new Book();
            $info = $info->getById($id)[0];
            //all info by batch_id
            $batchInfo = $qaBatches->getAllByBatchId($info->batch_id)[0];
            $licensorName = $licensor->getNameLicensorById($info->licensor_id)[0]->name;
        } catch (\Exception $exception) {
            $message = 'This [id] = ' . $id . '  not found in Books database';
            return view('search.infoById', ['message' => $message]);
        }
        if (isset($info->data_origin_id)) {
            $imageUrl = config('main.links.image.book') . $info->data_origin_id . '.jpg';
        } else {
            $isbn = explode('1000', $info->id, 2)[1];
            $imageUrl = config('main.links.image.book') . $isbn . '.jpg';
        }

        if ($batchInfo != null) {
            $batchInfo->title = explode($info->source . '_', $batchInfo->title, 2)[1];
            // Create links to aws bucket
            $licensorNameToArray = SearchController::normalizeBucketName($info->source);
            if ($licensorNameToArray != null) {
                $info->source = $licensorNameToArray;
            }
            $linkCopy = config('main.links.aws.cp') . config('main.links.aws.bucket.books') . '/' . $info->source . '/' . $batchInfo->title . ' ./';
            $linkShow = config('main.links.aws.ls') . config('main.links.aws.bucket.books') . '/' . $info->source . '/' . $batchInfo->title;
            // Create object for aws bucket
            $object = $info->source . '/' . $batchInfo->title;
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