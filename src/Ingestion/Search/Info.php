<?php

namespace Ingestion\Search;

use App\Models\Album;
use App\Models\AudioBook;
use App\Models\Book;
use App\Models\DataSourceProvider;
use App\Models\Game;
use App\Models\Licensor;
use App\Models\Movie;
use Aws\S3\S3Client;

/**
 * Class Info
 * @package Ingestion\Search
 */
class Info
{
    /**
     * @param $id
     * @param $mediaTypeTitle
     * @param $country_code
     * @param $mediaId
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function getInfoSelectedMediaTypes($id, $mediaTypeTitle, $country_code, $mediaId)
    {
        $licensor = new Licensor();
        $info = $this->getModel($mediaTypeTitle, $id);
        try {
            $imageUrl = $info->imageUrl;
            $info = $info->getById($id);
            $licensorName = $licensor->getNameLicensorById($info['licensor_id']);
            if (isset($info->data_source_provider_id)) {
                $providerName = new DataSourceProvider();
                $providerName = $providerName->getDataSourceProviderName($info['data_source_provider_id']);
            } else {
                $providerName = null;
            }

        } catch (\Exception $exception) {
            $message = 'This [id] = ' . $id . '  not found in Books database';
            return back()->with('message', $message);
        }
        if ($mediaTypeTitle == 'books') {
            $linkImageInBucket = config('main.links.aws.ls') . config('main.links.aws.bucket.books') . '/' . $providerName . '/' . $info['isbn'] . '.jpg';
            $s3 = new S3Client([
                'version'     => 'latest',
                'region'      => 'us-east-1',
                'credentials' => [
                    'key'    => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                ],
            ]);
            try {
                $response = $s3->doesObjectExist(config('main.links.aws.bucket.books'), $providerName . '/' . $info['isbn'] . '.jpg');
            } catch (\Exception $exception) {
                $exception->getMessage();
            }
        } else {
            $linkImageInBucket = null;
            $response = null;
        }

        $result = [
            'id'                => $id,
            'country_code'      => $country_code,
            'mediaTypeTitle'    => $mediaTypeTitle,
            'licensorName'      => $licensorName,
            'imageUrl'          => $imageUrl,
            'providerName'      => $providerName,
            'info'              => $info,
            'mediaId'           => $mediaId,
            'response'          => $response,
            'linkImageInBucket' => $linkImageInBucket
        ];

        return $result;
    }

    /**
     * @param $mediaTypeTitle
     * @param $id
     * @return Album|AudioBook|Book|Game|Movie
     */
    public function getModel($mediaTypeTitle, $id)
    {
        switch ($mediaTypeTitle) {
            case 'movies':
                $info = new Movie();
                $imageUrl = config('main.links.image.movie') . $id . '.jpg';
                break;
            case 'books':
                $info = new Book();
                if (strlen($id) > 5) {
                    $isbn = explode('1000', $id, 2)[1];
                } else {
                    $isbn = $id;
                }
                $imageUrl = config('main.links.image.book') . $isbn . '.jpg';
                break;
            case 'audiobooks':
                $info = new AudioBook();
                if (strlen($id) > 5) {
                    $idLink = substr($id, -5);
                } else {
                    $idLink = $id;
                }
                $imageUrl = config('main.links.image.audiobook') . $idLink . '.jpg';
                break;
            case 'games':
                $info = new Game();
                $imageUrl = config('main.links.image.game') . $id . '.jpg';
                break;
            case 'albums':
                $info = new Album();
                if (strlen($id) > 5) {
                    $idLink = substr($id, -7);
                } else {
                    $idLink = $id;
                }
                $imageUrl = config('main.links.image.album') . $idLink . '.jpg';
                break;

        }

        $info->imageUrl = $imageUrl;
        return $info;
    }
}