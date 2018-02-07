<?php

namespace Ingestion\Search;

use App\Models\Album;
use App\Models\FailedItems;
use App\Models\Licensor;
use App\Models\DataSourceProvider;
use App\Models\Music;
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
     * @param $mediaTypeTitle
     * @param $country_code
     * @param $mediaGeoRestrictGetMediaType
     * @return array
     * @throws \Exception
     */
    public static function searchInfoById($id, $mediaTypeTitle, $country_code, $mediaGeoRestrictGetMediaType)
    {
        $licensor = new Licensor();
        $qaBatches = new QaBatch();
        $musicAlbumArtists = new MusicAlbumArtist();
        $music = new Music();
        $tracks = $music->getMusicByAlbumId($id);
        $musicArtist = $musicAlbumArtists->getArtistByAlbumId($id);
        $nameMusicArtist = [];

        if (!$musicArtist->isEmpty()) {
            foreach ($musicArtist as $artist) {
                $musicArtistName = new MusicArtist();
                $nameMusicArtists = $musicArtistName->getNameArtistByArtistId($artist['artist_id']);
                if (!$nameMusicArtists->isEmpty()) {
                    foreach ($nameMusicArtists as $name) {
                        $nameMusicArtist = '[ '. $name['name'] . ' ]';
                    }
                }
            }
        }

        $info = new Album();
        $info = $info->getInfoById($id);

        if ($info->isEmpty()) {
            $message = 'This [id] = ' . $id . '  not found in Albums database';
            throw new \Exception($message);
        } elseif (count($info) == 1) {
            $info = $info[0];
        }

        $licensorName = $licensor->getNameLicensorById($info->licensor_id);
        $idLink = substr($id, -7);
        $firstSymbol = substr($idLink, 0, 1);

        if ($firstSymbol == 0) {
            $idLink = substr($id, -6);
        }

        $imageUrl = config('main.links.image.album') . $idLink . '.jpg';
        $batchInfo = $qaBatches->getAllByBatchId($info->batch_id);

        $providerName = new DataSourceProvider();
        $providerName = $providerName->getDataSourceProviderName($info->data_source_provider_id)->name;

        if ($batchInfo != null) {
            $failedItems = new FailedItems();
            $failedItems = $failedItems->getFailedItems($id);
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
            'artistName'                   => $nameMusicArtist,
            'tracks'                       => $tracks
        ];

        return $result;
    }
}