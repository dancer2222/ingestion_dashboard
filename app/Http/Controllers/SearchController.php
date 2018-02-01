<?php

namespace App\Http\Controllers;

use App\Models\MediaGeoRestrict;
use Illuminate\Http\Request;
use Ingestion\Search\Id;

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
        if (isset($request->id) && isset($request->type)) {
            if (!is_numeric($request->id)) {
                $message = 'This [id] = [' . $request->id . '] must contain only digits';

                return back()->with('message', $message);
            }

            $country_codeUnique = Id::search($request->id);
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
}
