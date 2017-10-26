<?php
/**
 * Created by PhpStorm.
 * User: dancer
 * Date: 26.10.17
 * Time: 12:26
 */

namespace Ingestion\Search;

use App\Models\Album;
use App\Models\AudioBook;
use App\Models\Book;
use App\Models\DataSourceProvider;
use App\Models\Game;
use App\Models\Licensor;
use App\Models\MediaGeoRestrict;
use App\Models\MediaType;
use App\Models\Movie;

class Info
{
    public function getInfoSelectedMediaTypes($id, $mediaTypeTitle, $country_code)
    {
        $licensor = new Licensor();
        $info = $this->getModel($mediaTypeTitle, $id);
        try {
            $imageUrl = $info->imageUrl;
            $info = $info->getById($id)[0];
            $licensorName = $licensor->getNameLicensorById($info->licensor_id)[0]->name;
            if (isset($info->data_source_provider_id)) {
                $providerName = new DataSourceProvider();
                $providerName = $providerName->getDataSourceProviderName($info->data_source_provider_id)[0]->name;
            } else {
                $providerName = null;
            }

        } catch (\Exception $exception) {
            $message = 'This [id] = ' . $id . '  not found in Books database';
            return back()->with('message', $message);
        }

        $result = [
            'id'             => $id,
            'country_code'   => $country_code,
            'mediaTypeTitle' => $mediaTypeTitle,
            'licensorName'   => $licensorName,
            'imageUrl'       => $imageUrl,
            'providerName'   => $providerName,
            'info'           => $info
        ];

        return $result;
    }

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