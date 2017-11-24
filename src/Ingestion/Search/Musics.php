<?php
/**
 * Created by PhpStorm.
 * User: dancer
 * Date: 23.11.17
 * Time: 12:24
 */

namespace Ingestion\Search;

use App\Models\DataSourceProvider;
use App\Models\Music;
use Illuminate\Http\Request;

/**
 * Class Musics
 * @package Ingestion\Search
 */
class Musics
{
    /**
     * @param $id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function searchInfoById($id)
    {
        $music = new Music();
        $info = $music->getTrackById($id);
        if ($info === null) {
            return $info;
        }
        $http_response_header = get_headers($info['download_url'])[13];

        $providerName = new DataSourceProvider();

        $providerName = $providerName->getDataSourceProviderName($info['data_source_provider_id'])['name'];

        $result = [
            'providerName' => $providerName,
            'info'         => $info,
            'presentEpub'  => '',
            'http_response_header' => $http_response_header
        ];

        return $result;
    }
}