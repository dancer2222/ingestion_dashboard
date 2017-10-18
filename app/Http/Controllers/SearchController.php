<?php

namespace App\Http\Controllers;

use App\Album;
use App\AudioBook;
use App\Book;
use App\DataSourceProvider;
use App\Game;
use App\Licensor;
use App\MediaGeoRestrict;
use App\MediaType;
use App\Movie;
use App\QaBatch;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * @param Request $request
     * @param null $id_url
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, $id_url = null)
    {
        $qaBatches = new QaBatch();
        $mediaType = new MediaType();
        $licensor = new Licensor();
        $country_code = '';

        if (isset($request->id)) {
            if (is_numeric($request->id) == false) {
                $message = 'This [id] = ['.$request->id.'] must contain only digits';
                return view('search.infoById', ['message' => $message]);
            }
            $mediaGeoRestrict = new MediaGeoRestrict();
            $mediaGeoRestrictInfo = $mediaGeoRestrict->getAllGeoRestrictionInfo($request->id);
            if ($mediaGeoRestrictInfo === null) {
                $message = 'This [id] = '.$request->id.'  not found';
                return view('search.infoById', ['message' => $message]);
            }
            if (count($mediaGeoRestrictInfo) > 1){
                $result = [];
                foreach ($mediaGeoRestrictInfo as $item ) {
                    $country_code .= $item->country_code .'.';
                    $result []= $item->media_type;
                  }
                  if (count($result) > 1) {
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
                              return view('search.selectMediaTypes', ['more' => $more, 'id' => $request->id,
                                                                      'mediaTypeTitles' => $mediaTypeTitles,
                                                                      'id_url' => $id_url,
                                                                      'option' => $request->option]);
                          }
                  }
                }
            } else {
                $country_code = $mediaGeoRestrictInfo[0]->country_code;
            }

            $mediaGeoRestrictGetMediaType = $mediaGeoRestrict->getFirstGeoRestrictionInfo($request->id);
            $mediaTypeTitle = $mediaType->getTitleById($mediaGeoRestrictGetMediaType->media_type)[0]->title;

            switch ($mediaTypeTitle) {
                case 'movies':
                    $info = new Movie();
                    //default bucket for movies
                    $bucket = 'playster-content-ingestion';
                    $info =$info->getMovieById($request->id)[0];
                    //all info by batch_id
                    $batchInfo = $qaBatches->getAllByBatchId($info->batch_id)[0];
                    $licensorName = $licensor->getNameLicensorById($info->licensor_id)[0]->name;

                    if ($batchInfo != null && false != stristr($batchInfo->title, '.')) {
                        $providerName = new DataSourceProvider();
                        $providerName = $providerName->getDataSourceProviderName($batchInfo->data_source_provider_id)[0]->name;
                        $batchInfo->title = explode($providerName.'_', $batchInfo->title, 2)[1];

                        // Create links to aws bucket
                        $licensorNameToArray = $this->normalizeBucketName($licensorName);
                        if ($licensorNameToArray != null) {
                            $licensorName = $licensorNameToArray;
                        }
                        $linkCopy = 'aws s3 cp s3://'.$bucket.'/'. $licensorName.'/'. $batchInfo->title.  ' ./';
                        $linkShow = 'aws s3 ls s3://'.$bucket.'/'. $licensorName.'/'. $batchInfo->title;
                        // Create object for aws bucket
                        $object = $licensorName.'/'. $batchInfo->title;
                    } else {
                        $linkCopy = null;
                        $linkShow = null;
                        $object = null;
                        $batchInfo = null;
                    }
                    return view('search.infoById', ['info' => (array)$info,
                                                                 'id' => $request->id,
                                                                 'mediaTypeTitle' => $mediaTypeTitle,
                                                                 'batchInfo' => $batchInfo,
                                                                 'mediaGeoRestrictInfo' => $country_code,
                                                                 'licensorName' => $licensorName,
                                                                 'option' => $request->option,
                                                                 'id_url' => $id_url,
                                                                 'linkCopy' => $linkCopy,
                                                                 'linkShow' => $linkShow,
                                                                 'bucket' => $bucket,
                                                                 'object' => $object]);
                    break;
                case 'books':
                    $info = new Book();
                    //default bucket for books
                    $bucket = 'playster-book-service-dump';
                    $info =$info->getBookById($request->id)[0];
                    //all info by batch_id
                    $batchInfo = $qaBatches->getAllByBatchId($info->batch_id)[0];
                    $licensorName = $licensor->getNameLicensorById($info->licensor_id)[0]->name;

                    if ($batchInfo != null) {
                        $batchInfo->title = explode($info->source.'_', $batchInfo->title, 2)[1];
                        // Create links to aws bucket
                        $licensorNameToArray = $this->normalizeBucketName($info->source);
                        if ($licensorNameToArray != null) {
                            $info->source = $licensorNameToArray;
                        }
                        $linkCopy = 'aws s3 cp s3://'.$bucket.'/'. $info->source.'/'. $batchInfo->title.  ' ./';
                        $linkShow = 'aws s3 ls s3://'.$bucket.'/'. $info->source.'/'. $batchInfo->title;
                        // Create object for aws bucket
                        $object = $info->source.'/'. $batchInfo->title;
                    } else {
                        $linkCopy = null;
                        $linkShow = null;
                        $object = null;
                    }
                    return view('search.infoById', ['info' => (array)$info,
                                                                 'id' => $info->id,
                                                                 'mediaTypeTitle' => $mediaTypeTitle,
                                                                 'batchInfo' => $batchInfo,
                                                                 'mediaGeoRestrictInfo' => $country_code,
                                                                 'licensorName' => $licensorName,
                                                                 'option' => $request->option,
                                                                 'id_url' => $id_url,
                                                                 'linkCopy' => $linkCopy,
                                                                 'linkShow' => $linkShow,
                                                                 'bucket' => $bucket,
                                                                 'object' => $object]);
                    break;

                case 'audiobooks':
                    $info = new AudioBook();
                    $info =$info->getAudioBookById($request->id)[0];
                    //all info by batch_id
                    $batchInfo = $qaBatches->getAllByBatchId($info->batch_id)[0];
                    $licensorName = $licensor->getNameLicensorById($info->licensor_id)[0]->name;
                    return view('search.infoById', ['info' => (array)$info,
                                                                 'id' => $request->id,
                                                                 'mediaTypeTitle' => $mediaTypeTitle,
                                                                 'batchInfo' => $batchInfo,
                                                                 'mediaGeoRestrictInfo' => $country_code,
                                                                 'licensorName' => $licensorName,
                                                                 'option' => $request->option,
                                                                 'id_url' => $id_url]);
                    break;

                case 'games':
                    $info = new Game();
                    $info =$info->getGameById($request->id)[0];
                    $licensorName = $licensor->getNameLicensorById($info->licensor_id)[0]->name;
                    return view('search.infoById', ['info' => (array)$info,
                                                            'id' => $info->id,
                                                            'mediaTypeTitle' => $mediaTypeTitle,
                                                            'mediaGeoRestrictInfo' => $country_code,
                                                            'licensorName' => $licensorName,
                                                            'option' => $request->option,
                                                            'id_url' => $id_url]);
                    break;

                case 'albums':
                    $info = new Album();
                    $info =$info->getAlbumById($request->id)[0];
                    $licensorName = $licensor->getNameLicensorById($info->licensor_id)[0]->name;
                    return view('search.infoById', ['info' => (array)$info,
                                                            'id' => $info->id,
                                                            'mediaTypeTitle' => $mediaTypeTitle,
                                                            'mediaGeoRestrictInfo' => $country_code,
                                                            'licensorName' => $licensorName,
                                                            'option' => $request->option,
                                                            'id_url' => $id_url]);
                    break;

                default:
                    return view('search.infoById');
            }
        }
        return view('search.infoById');
    }

    /**
     * @param Request $request
     * @param null $id_url
     * @param null $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function select(Request $request, $id_url = null, $type = null)
    {
        $licensor = new Licensor();
        $mediaType = new MediaType();
        $mediaGeoRestrict = new MediaGeoRestrict();
        if ($request->id == null) {
            return redirect(action('SearchController@index', ['id_url' => $id_url]));
        }
        if ($id_url != null && $type == null) {
            return redirect(action('SearchController@index', ['id_url' => $id_url]));
        }
        $mediaTypeTitle = $request->type;
        $mediId = $mediaType->getIdByTitle($mediaTypeTitle)[0]->media_type_id;
        $mediaInfo = $mediaGeoRestrict->getGeoRestrictionInfoByMediaType($request->id, $mediId);

        if ($mediaInfo === null) {
            $message = 'not exist id =  '. $request->id . ' with a  media type = '. $request->type;
            return back()->with('message', $message);
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
                                                        'option' => $request->option,
                                                        'id_url' => $id_url,
                                                        'type' => $type]);
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
                                                'option' => $request->option,
                                                'id_url' => $id_url,
                                                'type' => $type]);
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
                                                        'option' => $request->option,
                                                        'id_url' => $id_url,
                                                        'type' => $type]);
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
                                                        'option' => $request->option,
                                                        'id_url' => $id_url,
                                                        'type' => $type]);
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
                                                        'option' => $request->option,
                                                        'id_url' => $id_url,
                                                        'type' => $type]);
                break;
            default:
                return view('search.selectMediaTypes');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function indexRedirect(Request $request)
    {
        return redirect(action('SearchController@index', ['id_url' => $request->id,
                                                                'option' => $request->option]));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function selectRedirect(Request $request)
    {
        if (isset($request->type)) {
            return redirect(action('SearchController@select', ['id_url' => $request->id,
                                                                     'type' => $request->type,
                                                                     'option' => $request->option]));
        } else {
            return redirect(action('SearchController@select', ['id_url' => $request->id,
                                                                     'option' => $request->option]));
        }

    }

    /**
     * @param $licensorName
     * @return mixed
     */
    public function normalizeBucketName($licensorName)
    {
        $providers = [
            'Aenetworks' => 'aenetworks',
            'Imira' => 'imira',
            'Brainstorm Media' => 'brainmedia',
            'EntertainmentOne' => 'eone',
            '9StoryMedia' => '9storymedia',
            'Baker' => 'baker',
            'BBC' => 'bbc',
            'Corus' => 'corus',
            'DeMarque' => 'demarque',
            'DHXMedia' => 'dhxmedia',
            'Draft2Digital' => 'draft2digital',
            'DynamiteComics' => 'dynamitecomics',
            'Firebrand' => 'Firebrand',
            'Nelvana' => 'corus',
            'Harlequin' => 'Harlequin',
            'HarlequinGermany' => 'Harlequin-Germany',
            'HarlequinIberica' => 'harl-iberica',
            'HarperCollins' => 'harcol',
            'HarperCollinsUK' => 'HarperCollins',
            'hasbro' => 'hasbro',
            'IDW' => 'idwpub',
            'IPG' => 'IPG',
            'JoMedia' => 'JoMedia',
            'NationalGeographic' => 'nationalgeographic',
            'Palatium' => 'palatium',
            'Parkstone' => 'parkstone',
            'pickatale' => 'pickatale',
            'Pubdrive' => 'pubdrive',
            'RedWheelWeiser' => 'rwwbooks',
            'SandrewMetronome' => 'sandrewmetronome',
            'Scanbox' => 'scanbox',
            'Screenmedia' => 'screenmedia',
            'SimonAndSchuster' => 'simonschuster',
            'StreetLib' => 'streetlib',
            'TheOrchard' => 'theorchard',
            'TwinSisters' => 'twinsisters',
            'UnderTheMilkyWay' => 'underthemilkyway',
            'Vearsa' => 'vearsa',
        ];

        foreach ($providers as $provider => $value) {
            if (mb_strtolower($provider) == mb_strtolower($licensorName)) {
                return $value;
                break;
            }
        }
    }
}
