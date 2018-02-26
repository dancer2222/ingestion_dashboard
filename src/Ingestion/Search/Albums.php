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
class Albums extends MediaTypeAbstract
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
                        $nameMusicArtist = '[ ' . $name['name'] . ' ]';
                    }
                }
            }
        }

        $info = new Album();
        $info = $info->getInfoById($id);
        $info = $this->toArray($info, $id, $mediaTypeTitle);

        $licensorName = $licensor->getNameLicensorById($info['licensor_id']);
        $idLink = substr($id, -7);
        $firstSymbol = substr($idLink, 0, 1);

        if ($firstSymbol == 0) {
            $idLink = substr($id, -6);
        }

        $imageUrl = config('main.links.image.album') . $idLink . '.jpg';
        $batchInfo = $qaBatches->getAllByBatchId($info['batch_id']);

        $providerName = new DataSourceProvider();
        $providerName = $providerName->getDataSourceProviderName($info['data_source_provider_id']);

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