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
     * @param Music $music
     * @param MusicFiles $musicFiles
     * @return array
     */
    public function searchInfoById($id, Music $music, MusicFiles $musicFiles): array
    {
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

        $dataSourceProvider = new DataSourceProvider();

        if ($dataSourceProvider->getDataSourceProviderName($info['data_source_provider_id'])) {
            $providerName = $dataSourceProvider->getDataSourceProviderName($info['data_source_provider_id'])->name;
        }

        $result = [
            'providerName' => $providerName,
            'info' => $info,
            'country_code' => $geoRestrictArrayUnique
        ];

        return $result;
    }
}