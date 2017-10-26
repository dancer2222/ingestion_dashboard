<?php

namespace App\Http\Controllers;

use App\Models\MediaGeoRestrict;
use App\Models\MediaType;
use Illuminate\Http\Request;
use Ingestion\Search\Albums;
use Ingestion\Search\AudioBooks;
use Ingestion\Search\Books;
use Ingestion\Search\Games;
use Ingestion\Search\Movies;
use Ingestion\Search\Info;

class SearchController extends Controller
{
    /**
     * @param Request $request
     * @param null $id_url
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, $id_url = null)
    {
        $dataForView = [];
        $mediaType = new MediaType();
        $country_code = '';

        if (isset($request->id)) {
            if (!is_numeric($request->id)) {
                $message = 'This [id] = [' . $request->id . '] must contain only digits';
                return view('search.infoById', ['message' => $message]);
            }

            $mediaGeoRestrict = new MediaGeoRestrict();
            $mediaGeoRestrictInfo = $mediaGeoRestrict->getAllGeoRestrictionInfo($request->id);
            if ($mediaGeoRestrictInfo === null) {
                $message = 'This [id] = ' . $request->id . '  not found';
                return view('search.infoById', ['message' => $message]);
            }
            if (count($mediaGeoRestrictInfo) > 1) {
                $result = [];
                foreach ($mediaGeoRestrictInfo as $item) {
                    $country_code .= $item->country_code . '.';
                    $result [] = $item->media_type;
                }
                $resultUnique = array_unique($result);
                if (count($resultUnique) > 1) {
                    foreach ($resultUnique as $mediaTypes) {
                        $mediaTypeTitles [] = $mediaType->getTitleById($mediaTypes)[0]->title;
                    }
                    $more = '';
                    return view('search.selectMediaTypes', [
                        'more'            => $more,
                        'id'              => $request->id,
                        'mediaTypeTitles' => $mediaTypeTitles,
                        'id_url'          => $id_url,
                        'option'          => $request->option
                    ]);
                }
            } else {
                $country_code = $mediaGeoRestrictInfo[0]->country_code;
            }

            $mediaGeoRestrictGetMediaType = $mediaGeoRestrict->getFirstGeoRestrictionInfo($request->id);
            $mediaTypeTitle = $mediaType->getTitleById($mediaGeoRestrictGetMediaType->media_type)[0]->title;

            switch ($mediaTypeTitle) {
                case 'movies':
                    $dataForView = Movies::searchInfoById($request->id, $mediaTypeTitle, $country_code);

                    break;
                case 'books':
                    $dataForView = Books::searchInfoById($request->id, $mediaTypeTitle, $country_code);

                    break;

                case 'audiobooks':
                    $dataForView = AudioBooks::searchInfoById($request->id, $mediaTypeTitle, $country_code);

                    break;

                case 'games':
                    $dataForView = Games::searchInfoById($request->id, $mediaTypeTitle, $country_code);

                    break;

                case 'albums':
                    $dataForView = Albums::searchInfoById($request->id, $mediaTypeTitle, $country_code);

                    break;
            }
        }

        $dataForView['option'] = $request->option;
        $dataForView['id_url'] = $id_url;
        return view('search.infoById', $dataForView);
    }

    /**
     * @param Request $request
     * @param null $id_url
     * @param null $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function select(Request $request, $id_url = null, $type = null)
    {
        $mediaType = new MediaType();
        $mediaGeoRestrict = new MediaGeoRestrict();
        if ($request->id == null) {
            return redirect(action('SearchController@index', ['id_url' => $id_url]));
        }
        if ($id_url != null && $type == null) {
            return redirect(action('SearchController@index', ['id_url' => $id_url]));
        }
        try {
            $mediaTypeTitle = $request->type;
            $mediId = $mediaType->getIdByTitle($mediaTypeTitle)[0]->media_type_id;
        } catch (\Exception $exception) {
            $message = 'Not found ID by this title =' . $mediaTypeTitle;
            return redirect(action('SearchController@index', ['id_url' => $id_url]))->with('message', $message);
        }

        $mediaInfo = $mediaGeoRestrict->getGeoRestrictionInfoByMediaType($request->id, $mediId);

        if ($mediaInfo === null) {
            $message = 'not exist id =  ' . $request->id . ' with a  media type = ' . $request->type;
            return back()->with('message', $message);
        }
        $country_code = $mediaInfo[0]->country_code;
        $info = new Info();
        $result = $info->getInfoSelectedMediaTypes($request->id, $mediaTypeTitle, $country_code);

        return view('search.selectMediaTypes', [
            'info'                 => (array)$result['info'],
            'id'                   => $result['id'],
            'mediaTypeTitle'       => $result['mediaTypeTitle'],
            'mediaGeoRestrictInfo' => $result['country_code'],
            'licensorName'         => $result['licensorName'],
            'imageUrl'             => $result['imageUrl'],
            'providerName'         => $result['providerName'],
            'option'               => $request->option,
            'id_url'               => $id_url,
            'type'                 => $type
        ]);
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
                                                               'type'   => $request->type,
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
    public static function normalizeBucketName($licensorName)
    {
        $providers = [
            'Aenetworks'         => 'aenetworks',
            'Imira'              => 'imira',
            'Brainstorm Media'   => 'brainmedia',
            'EntertainmentOne'   => 'eone',
            '9StoryMedia'        => '9storymedia',
            'Baker'              => 'baker',
            'BBC'                => 'bbc',
            'Corus'              => 'corus',
            'DeMarque'           => 'demarque',
            'DHXMedia'           => 'dhxmedia',
            'Draft2Digital'      => 'draft2digital',
            'DynamiteComics'     => 'dynamitecomics',
            'Firebrand'          => 'Firebrand',
            'Nelvana'            => 'corus',
            'Harlequin'          => 'Harlequin',
            'HarlequinGermany'   => 'Harlequin-Germany',
            'HarlequinIberica'   => 'harl-iberica',
            'HarperCollins'      => 'harcol',
            'HarperCollinsUK'    => 'harcol',
            'hasbro'             => 'hasbro',
            'IDW'                => 'idwpub',
            'IPG'                => 'IPG',
            'JoMedia'            => 'JoMedia',
            'NationalGeographic' => 'nationalgeographic',
            'Palatium'           => 'palatium',
            'Parkstone'          => 'parkstone',
            'pickatale'          => 'pickatale',
            'Pubdrive'           => 'pubdrive',
            'RedWheelWeiser'     => 'rwwbooks',
            'SandrewMetronome'   => 'sandrewmetronome',
            'Scanbox'            => 'scanbox',
            'Screenmedia'        => 'screenmedia',
            'SimonAndSchuster'   => 'simonschuster',
            'StreetLib'          => 'streetlib',
            'TheOrchard'         => 'theorchard',
            'TwinSisters'        => 'twinsisters',
            'UnderTheMilkyWay'   => 'underthemilkyway',
            'Vearsa'             => 'vearsa',
        ];

        foreach ($providers as $provider => $value) {
            if (mb_strtolower($provider) == mb_strtolower($licensorName)) {
                return $value;
                break;
            }
        }
    }
}
