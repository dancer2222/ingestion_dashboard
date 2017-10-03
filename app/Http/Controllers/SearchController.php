<?php

namespace App\Http\Controllers;

use App\Album;
use App\AudioBook;
use App\Book;
use App\Game;
use App\Licensor;
use App\MediaGeoRestrict;
use App\MediaType;
use App\Movie;
use App\QaBatch;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $qaBatches = new QaBatch();
        $mediaType = new MediaType();
        $licensor = new Licensor();
        $country_code = '';

        if (isset($request->id)) {
            $mediaGeoRestrict = new MediaGeoRestrict();
            $mediaGeoRestrictInfo = $mediaGeoRestrict->getAllGeoRestrictionInfo($request->id);
            if (count($mediaGeoRestrictInfo) > 1){
                $result = [];
                foreach ($mediaGeoRestrictInfo as $item ) {
                    $country_code .= $item->country_code .'.';
                    $result []= $item->media_type;
                  }

                for ($i = 0; $i < count($result); $i++)
                {
                    if ($result[0] != $result[$i]) {
                        $more = '';
                        $mediaRestAllMediaType = $mediaGeoRestrict->getAllGeoRestrictionInfo($request->id);
                        foreach ($mediaRestAllMediaType as $value) {
                            $allMediaType []= $value->media_type;
                        }
                        $allMediaType = array_unique($allMediaType);
                        foreach ($allMediaType as $mediaTypes) {
                            $mediaTypeTitles []= $mediaType->getTitleById($mediaTypes)[0]->title;
                        }
                        return view('search.selectMediaTypes', ['more' => $more, 'id' => $request->id, 'mediaTypeTitles' => $mediaTypeTitles]);
                    } else {
                        $mediaGeoRestrictGetMediaType = $mediaGeoRestrict->getFirstGeoRestrictionInfo($request->id);
                        $mediaTypeTitle = $mediaType->getTitleById($mediaGeoRestrictGetMediaType->media_type)[0]->title;
                    }
                }

            } else {
                $mediaGeoRestrictGetMediaType = $mediaGeoRestrict->getFirstGeoRestrictionInfo($request->id);
                $mediaTypeTitle = $mediaType->getTitleById($mediaGeoRestrictGetMediaType->media_type)[0]->title;
                $country_code = $mediaGeoRestrictInfo[0]->country_code;
            }


            switch ($mediaTypeTitle) {
                case 'movies':
                    $info = new Movie();
                    $info =$info->getMovieById($request->id)[0];
                    $batchInfo = $qaBatches->getAllByBatchId($info->batch_id)[0];
                    $licensorName = $licensor->getNameLicensorById($info->licensor_id)[0]->name;
                    $batchInfo->title = explode($licensorName.'_', $batchInfo->title, 2)[1];
                    return view('search.infoById', ['info' => (array)$info,
                                                                 'id' => $request->id,
                                                                 'mediaTypeTitle' => $mediaTypeTitle,
                                                                 'batchInfo' => $batchInfo,
                                                                 'mediaGeoRestrictInfo' => $country_code,
                                                                 'licensorName' => $licensorName,
                                                                 'option' => $request->option]);
                    break;
                case 'books':
                    $info = new Book();
                    $info =$info->getBookById($request->id)[0];
                    $batchInfo = $qaBatches->getAllByBatchId($info->batch_id)[0];
                    $licensorName = $licensor->getNameLicensorById($info->licensor_id)[0]->name;
                    $batchInfo->title = explode($licensorName.'_', $batchInfo->title, 2)[1];
                    return view('search.infoById', ['info' => (array)$info,
                                                                 'id' => $info->id,
                                                                 'mediaTypeTitle' => $mediaTypeTitle,
                                                                 'batchInfo' => $batchInfo,
                                                                 'mediaGeoRestrictInfo' => $country_code,
                                                                 'licensorName' => $licensorName,
                                                                 'option' => $request->option]);
                    break;

                case 'audiobooks':
                    $info = new AudioBook();
                    $info =$info->getAudioBookById($request->id)[0];
                    $batchInfo = $qaBatches->getAllByBatchId($info->batch_id)[0];
                    $licensorName = $licensor->getNameLicensorById($info->licensor_id)[0]->name;
                    return view('search.infoById', ['info' => (array)$info,
                                                                 'id' => $request->id,
                                                                 'mediaTypeTitle' => $mediaTypeTitle,
                                                                 'batchInfo' => $batchInfo,
                                                                 'mediaGeoRestrictInfo' => $country_code,
                                                                 'licensorName' => $licensorName,
                                                                 'option' => $request->option]);
                    break;

                case 'games':
                    $info = new Game();
                    $info =$info->getGameById($request->id)[0];
                    $licensorName = $licensor->getNameLicensorById($info->licensor_id)[0]->name;
                    return view('search.selectMediaTypes', ['info' => (array)$info,
                                                            'id' => $info->id,
                                                            'mediaTypeTitle' => $mediaTypeTitle,
                                                            'mediaGeoRestrictInfo' => $country_code,
                                                            'licensorName' => $licensorName,
                                                            'option' => $request->option]);
                    break;

                case 'albums':
                    $info = new Album();
                    $info =$info->getAlbumById($request->id)[0];
                    $licensorName = $licensor->getNameLicensorById($info->licensor_id)[0]->name;
                    return view('search.selectMediaTypes', ['info' => (array)$info,
                                                            'id' => $info->id,
                                                            'mediaTypeTitle' => $mediaTypeTitle,
                                                            'mediaGeoRestrictInfo' => $country_code,
                                                            'licensorName' => $licensorName,
                                                            'option' => $request->option]);
                    break;

                default:
                    return view('search.infoById');
            }
        }
        return view('search.infoById');
    }

    public function select(Request $request)
    {
        $licensor = new Licensor();
        $mediaType = new MediaType();
        $mediaGeoRestrict = new MediaGeoRestrict();
        $mediaTypeTitle = $request->type;
        $mediId = $mediaType->getIdByTitle($mediaTypeTitle)[0]->media_type_id;
        $mediaInfo = $mediaGeoRestrict->getGeoRestrictionInfoByMediaType($request->id, $mediId);
        if ($mediaInfo === null) {
            $more = '';
            $message = 'not exist id =  '. $request->id . ' with a  media type = '. $request->type;

            return view('search.selectMediaTypes', ['more' => $more, 'id' => $request->id, 'message' => $message]);
        }
        $country_code = $mediaInfo[0]->country_code;
        switch ($mediaTypeTitle) {
            case 'movies':
                $info = new Movie();
                $info =$info->getMovieById($request->id)[0];
                $licensorName = $licensor->getNameLicensorById($info->licensor_id)[0]->name;
                return view('search.selectMediaTypes', ['info' => (array)$info,
                                                        'id' => $info->id,
                                                        'mediaTypeTitle' => $mediaTypeTitle,
                                                        'mediaGeoRestrictInfo' => $country_code,
                                                        'licensorName' => $licensorName,
                                                        'option' => $request->option]);
                break;
            case 'books':
                $info = new Book();
                $info =$info->getBookById($request->id)[0];
                $licensorName = $licensor->getNameLicensorById($info->licensor_id)[0]->name;
                return view('search.selectMediaTypes', ['info' => (array)$info,
                                                'id' => $info->id,
                                                'mediaTypeTitle' => $mediaTypeTitle,
                                                'mediaGeoRestrictInfo' => $country_code,
                                                'licensorName' => $licensorName,
                                                'option' => $request->option]);
                break;

            case 'audiobooks':
                $info = new AudioBook();
                $info =$info->getAudioBookById($request->id)[0];
                $licensorName = $licensor->getNameLicensorById($info->licensor_id)[0]->name;
                return view('search.selectMediaTypes', ['info' => (array)$info,
                                                        'id' => $info->id,
                                                        'mediaTypeTitle' => $mediaTypeTitle,
                                                        'mediaGeoRestrictInfo' => $country_code,
                                                        'licensorName' => $licensorName,
                                                        'option' => $request->option]);
                break;

            case 'games':
                $info = new Game();
                $info =$info->getGameById($request->id)[0];
                $licensorName = $licensor->getNameLicensorById($info->licensor_id)[0]->name;
                return view('search.selectMediaTypes', ['info' => (array)$info,
                                                        'id' => $info->id,
                                                        'mediaTypeTitle' => $mediaTypeTitle,
                                                        'mediaGeoRestrictInfo' => $country_code,
                                                        'licensorName' => $licensorName,
                                                        'option' => $request->option]);
                break;

            case 'albums':
                $info = new Album();
                $info =$info->getAlbumById($request->id)[0];
                $licensorName = $licensor->getNameLicensorById($info->licensor_id)[0]->name;
                return view('search.selectMediaTypes', ['info' => (array)$info,
                                                        'id' => $info->id,
                                                        'mediaTypeTitle' => $mediaTypeTitle,
                                                        'mediaGeoRestrictInfo' => $country_code,
                                                        'licensorName' => $licensorName,
                                                        'option' => $request->option]);
                break;
            default:
                return view('search.selectMediaTypes');
        }
    }

//    public function indexRedirect(Request $request)
//    {
//        return redirect('SearchController@index', ['id' => $request->id, '$request' => $request]);
//    }
}
