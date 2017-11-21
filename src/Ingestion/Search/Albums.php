<?php

namespace Ingestion\Search;

use App\Models\Album;
use App\Models\FailedItems;
use App\Models\Licensor;
use App\Models\DataSourceProvider;
use App\Models\MusicAlbumArtist;
use App\Models\MusicArtist;
use App\Models\QaBatch;

/**
 * Class Albums
 * @package Ingestion\Reports
 */
class Albums
{
    /**
     * @param $id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function searchInfoById($id, $mediaTypeTitle, $country_code, $mediaGeoRestrictGetMediaType)
    {
        $licensor = new Licensor();
        $qaBatches = new QaBatch();
        $musicAlbumArtists = new MusicAlbumArtist();

        $musicArtist = $musicAlbumArtists->getArtistByAlbumId($id);
        $nameMusicArtist = [];
        if ($musicArtist != null) {
            $musicArtistName = new MusicArtist();
            $nameMusicArtist = $musicArtistName->getNameArtistByArtistId($musicArtist['artist_id']);
        }
        try {
            $info = new Album();
            $info = $info->getById($id);
            $licensorName = $licensor->getNameLicensorById($info['licensor_id']);
            $idLink = substr($id, -7);
            $imageUrl = config('main.links.image.album') . $idLink . '.jpg';
            $batchInfo = $qaBatches->getAllByBatchId($info['batch_id']);
        } catch (\Exception $exception) {
            $message = 'This [id] = ' . $id . '  not found in Albums database';
            return view('search.infoById', ['message' => $message]);
        }
        $providerName = new DataSourceProvider();
        $providerName = $providerName->getDataSourceProviderName($info['data_source_provider_id']);
        if ($batchInfo != null) {
            $failedItems = new FailedItems();
            $failedItems = $failedItems->getFailedItems($id, $info['batch_id']);
        } else {
            $failedItems = null;
        }
        $result = [
            'id'                           => $id,
            'country_code'                 => $country_code,
            'mediaTypeTitle'               => $mediaTypeTitle,
            'licensorName'                 => $licensorName,
            'info'                         => $info,
            'providerName'                 => $providerName,
            'imageUrl'                     => $imageUrl,
            'mediaGeoRestrictGetMediaType' => $mediaGeoRestrictGetMediaType,
            'messages'                     => $failedItems,
            'artistName'                   => $nameMusicArtist['name']
        ];

        return $result;
    }
}