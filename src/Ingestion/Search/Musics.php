<?php

namespace Ingestion\Search;

use App\Models\DataSourceProvider;
use App\Models\Music;
use App\Models\MusicFiles;

/**
 * Class Musics
 * @package Ingestion\Search
 */
class Musics
{
    /**
     * @param $id
     * @return array
     */
    public static function searchInfoById($id)
    {
        $music = new Music();
        $musicFiles = new MusicFiles();

        $info = $music->getTrackById($id);

        if ($info->isEmpty()) {
            return $info;
        } else {
            $info = $info->toArray()[0];
        }

        $geoRestrict = $musicFiles->getGeoRestrictMusicFilesById($id);
        $geoRestrictArrayUnique = [];

        if ($geoRestrict->isEmpty()) {
            $countryCode [] = 'This [id] = ' . $id . '  not found in mediaGeoRestrict';
        } else {
            $geoRestrictArrayUnique = array_map("unserialize",
                array_unique(array_map("serialize", $geoRestrict->toArray())));
        }

        $http_response_header = get_headers($info['download_url'])[13];

        $providerName = new DataSourceProvider();
        $providerName = $providerName->getDataSourceProviderName($info['data_source_provider_id'])['name'];

        $result = [
            'providerName'         => $providerName,
            'info'                 => $info,
            'http_response_header' => $http_response_header,
            'country_code'         => $geoRestrictArrayUnique
        ];

        return $result;
    }
}