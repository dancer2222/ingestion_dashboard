<?php

namespace App\Http\Controllers;

use Ingestion\Search\Musics;

/**
 * Class TrackController
 * @package App\Http\Controllers
 */
class TrackController extends Controller
{
    /**
     * @param $id
     * @param $option
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index($id, $option)
    {
        try {
            $dataForView = Musics::searchInfoById($id);

        } catch (\Exception $exception) {
            $message = 'This [id] = ' . $id . '  not found';

            return back()->with('message', $message);
        }

        if ($dataForView === null) {
            $message = 'This [id] = ' . $id . '  not found';

            return back()->with('message', $message);
        }
        $dataForView['option'] = $option;
        $dataForView['id_url'] = $id;

        return view('search.Trakcs', $dataForView);
    }
}
