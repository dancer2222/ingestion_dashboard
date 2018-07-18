<?php

namespace App\Http\Controllers;

use App\Models\Music;
use App\Models\MusicFiles;
use App\Models\TrackingStatusChanges;
use Ingestion\Search\Musics;

/**
 * Class TrackController
 * @package App\Http\Controllers
 */
class TrackController extends Controller
{
    /**
     * @param $id
     * @param Musics $musics
     * @param MusicFiles $musicFiles
     * @param TrackingStatusChanges $trackingStatusChanges
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index($id, Musics $musics, MusicFiles $musicFiles, TrackingStatusChanges $trackingStatusChanges)
    {
        try {
            $dataForView = $musics->searchInfoById($id, new Music(), $musicFiles);
        } catch (\Exception $exception) {
            $message = 'This [id] = ' . $id . '  not found';

            return back()->with('message', $message);
        }

        if ($dataForView === null) {
            $message = 'This [id] = ' . $id . '  not found';

            return back()->with('message', $message);
        }

        $dataForView['id_url'] = $id;

        $statusInfo = $trackingStatusChanges->getInfoById($id);

        if (!$statusInfo->isEmpty()) {
            $statusInfo->toArray();
        } else {
            $statusInfo = null;
        }

        $dataForView['statusInfo'] = $statusInfo;

        return view('search.Tracks', $dataForView);
    }
}
