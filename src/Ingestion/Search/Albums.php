<?php
/**
 * Created by PhpStorm.
 * User: dancer
 * Date: 26.10.17
 * Time: 10:50
 */

namespace Ingestion\Search;

use App\Models\Album;
use App\Models\Licensor;
use App\Models\DataSourceProvider;

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
    public static function searchInfoById($id, $mediaTypeTitle, $country_code)
    {
        $licensor = new Licensor();
        try {
            $info = new Album();
            $info = $info->getById($id)[0];
            $licensorName = $licensor->getNameLicensorById($info->licensor_id)[0]->name;
            $idLink = substr($id, -7);
            $imageUrl = config('main.links.image.album') . $idLink . '.jpg';
        } catch (\Exception $exception) {
            $message = 'This [id] = ' . $id . '  not found in Albums database';
            return view('search.infoById', ['message' => $message]);
        }
        $providerName = new DataSourceProvider();
        $providerName = $providerName->getDataSourceProviderName($info->data_source_provider_id)[0]->name;

        $result = [
            'id'             => $id,
            'country_code'   => $country_code,
            'mediaTypeTitle' => $mediaTypeTitle,
            'licensorName'   => $licensorName,
            'info'           => (array)$info,
            'providerName'   => $providerName,
            'imageUrl'       => $imageUrl
        ];

        return $result;
    }
}