<?php

namespace App\Http\Controllers;

use Ingestion\Search\Musics;

class TrackController extends Controller
{
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
