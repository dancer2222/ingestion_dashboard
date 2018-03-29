<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ingestion\Search\GeoRestrict;

/**
 * Class SearchController
 * @package App\Http\Controllers
 */
class SearchController extends Controller
{
    /**
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if (isset($request->id) && isset($request->type)) {
            if (!is_numeric($request->id)) {
                $message = 'This [id] = [' . $request->id . '] must contain only digits';

                return back()->with('message', $message);
            }

            $className = "Ingestion\Search\\" . ucfirst($request->type);

            try {
                $reflectionMethod = new \ReflectionMethod($className, 'searchInfoById');
            } catch (\ReflectionException $exception) {
                return view('search.infoById')->withErrors($exception->getMessage());
            }

            try {
                $dataForView = $reflectionMethod->invoke(
                    new $className(),
                    $request->id,
                    $request->type,
                    GeoRestrict::search($request->id),
                    $request->type
                );
            } catch (\Exception $exception) {
                return view('search.infoById')->withErrors($exception->getMessage());
            }

            $dataForView['option'] = $request->option;

            return view('search.infoById', $dataForView);
        }

        return view('search.infoById');
    }
}
