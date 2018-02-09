<?php

namespace Ingestion\Search;

use App\Models\Book;
use App\Models\FailedItems;
use App\Models\Licensor;
use App\Models\MaLanguage;
use App\Models\MediaLanguage;
use App\Models\QaBatch;
use Aws\S3\S3Client;

/**
 * Class Books
 * @package Ingestion\Reports
 */
class Books extends MediaTypeAbstract
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
    public function searchInfoById($id, $mediaTypeTitle, $country_code, $mediaGeoRestrictGetMediaType)
    {
        $qaBatches = new QaBatch();
        $licensor = new Licensor();
        $mediaLenguage = new MediaLanguage();
        $maLanguage = new MaLanguage();
        $info = new Book();

        $info = $info->getInfoById($id);
        $info = $this->toArray($info, $id, $mediaTypeTitle);
        $langId = $mediaLenguage->getBookLanguageId($id);
        $langName = $maLanguage->getLanguageNameByLanguageId($langId['language_id'])['name'];
        $info['language'] = $langName;

        //all info by batch_id
        $batchInfo = $qaBatches->getAllByBatchId($info['batch_id']);
        $licensorName = $licensor->getNameLicensorById($info['licensor_id']);

        if (isset($info['data_origin_id'])) {
            $imageUrl = config('main.links.image.book') . $info['data_origin_id'] . '.jpg';
        } else {
            $isbn = explode('1000', $info['id'], 2)[1];
            $imageUrl = config('main.links.image.book') . $isbn . '.jpg';
        }

        if ($batchInfo != null) {
            $batchInfo['title'] = explode($info['source'] . '_', $batchInfo['title'], 2)[1];

            // Create links to aws bucket
            $licensorNameToArray = Normalize::normalizeBucketName($info['source']);
            if ($licensorNameToArray != null) {
                $info['source'] = $licensorNameToArray;
            }
            $linkCopy = config('main.links.aws.cp') . config('main.links.aws.bucket.books') . '/' . $info['source'] . '/' . $batchInfo['title'] . ' ./';
            $linkShow = config('main.links.aws.ls') . config('main.links.aws.bucket.books') . '/' . $info['source'] . '/' . $batchInfo['title'];
            $linkImageInBucket = config('main.links.aws.ls') . config('main.links.aws.bucket.books') . '/' . $info['source'] . '/' . $info['isbn'] . '.jpg';
            $s3 = new S3Client([
                'version'     => 'latest',
                'region'      => 'us-east-1',
                'credentials' => [
                    'key'    => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                ],
            ]);

            $response = $s3->doesObjectExist(config('main.links.aws.bucket.books'),
                $info['source'] . '/' . $info['isbn'] . '.jpg');
            $presentEpub = $s3->doesObjectExist(config('main.links.aws.bucket.books'),
                $info['source'] . '/' . $info['download_url']);

            // Create object for aws bucket
            $object = $info['source'] . '/' . $batchInfo['title'];
            $failedItems = new FailedItems();
            $failedItems = $failedItems->getFailedItems($info['isbn']);
        } else {
            $linkCopy = null;
            $linkShow = null;
            $object = null;
            $batchInfo = null;
            $failedItems = null;
            $presentEpub = null;
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
            'response'                     => $response,
            'linkImageInBucket'            => $linkImageInBucket,
            'messages'                     => $failedItems,
            'presentEpub'                  => $presentEpub,
            'langName'                     => $langName

        ];

        return $result;
    }
}