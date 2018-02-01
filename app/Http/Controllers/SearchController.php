<?php

namespace App\Http\Controllers;

use App\Models\MediaGeoRestrict;
use Illuminate\Http\Request;

/**
 * Class SearchController
 * @package App\Http\Controllers
 */
class SearchController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \ReflectionException
     */
    public function index(Request $request)
    {
        $country_code = [];

        if (isset($request->id) && isset($request->type)) {
            if (!is_numeric($request->id)) {
                $message = 'This [id] = [' . $request->id . '] must contain only digits';

                return back()->with('message', $message);
            }

            try{
                $mediaGeoRestrict = new MediaGeoRestrict();
                $mediaGeoRestrictInfo = $mediaGeoRestrict->getAllGeoRestrictionInfo($request->id);
            } catch (\Exception $exception) {
                return back()->with(['message' => $exception->getMessage()]);
            }

            //add in country_code status inactive
            if ($mediaGeoRestrictInfo !== null) {
                foreach ($mediaGeoRestrictInfo as &$item) {
                    if ($item['status'] == 'inactive') {
                        $item['country_code'] = 'inactive';
                    }
                }
            }

            //have more geo restrict info
            if (count($mediaGeoRestrictInfo) > 1) {

                foreach ($mediaGeoRestrictInfo as $value) {
                    $country_code[] = $value['country_code'];
                }

                $country_codeUnique = array_unique($country_code);

                if (count($country_codeUnique) > 1) {
                    foreach ($country_codeUnique as &$code) {
                        if ($code == 'inactive') {
                            $code = null;
                        }
                    }
                }

            } else {

                if ($mediaGeoRestrictInfo === null) {
                    $country_codeUnique [] = 'This [id] = ' . $request->id . '  not found in mediaGeoRestrict';
                } else {
                    $country_codeUnique [] = $mediaGeoRestrictInfo[0]['country_code'];
                }
            }

            $className = new \ReflectionMethod("Ingestion\Search\\" . ucfirst($request->type), 'searchInfoById');

            try {
                $dataForView = $className->invoke(null, $request->id, $request->type, $country_codeUnique,
                    $request->type);
            } catch (\Exception $exception) {

                return view('search.infoById')->withErrors($exception->getMessage());
            }

            $dataForView['option'] = $request->option;

            return view('search.infoById', $dataForView);
        }

        return view('search.infoById');
    }

    /**
     * @param $licensorName
     *
     * @return mixed
     */
    public static function normalizeBucketName($licensorName)
    {
        $providers = [
            'Aenetworks' => 'aenetworks',
            'Imira' => 'imira',
            'Brainstorm Media' => 'brainmedia',
            'EntertainmentOne' => 'eone',
            '9StoryMedia' => '9storymedia',
            'Baker' => 'baker',
            'BBC' => 'bbc',
            'BrainStormMedia' => 'brainmedia',
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
            'HarperCollins' => 'harper-collins-us',
            'HarperCollinsUK' => 'harper-collins-us',
            'ThomasNelson' => 'harper-collins-us/Thomas_Nelson',
            'GrupoNelson' => 'harper-collins-us/Grupo_Nelson',
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
