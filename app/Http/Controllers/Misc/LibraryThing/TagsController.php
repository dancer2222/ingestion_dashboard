<?php

namespace App\Http\Controllers\Misc\LibraryThing;

use App\Helpers\Ingestion\Tags\LibraryThingHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function index(LibraryThingHelper $helper)
    {
        $viewData = [];
        $viewData['localFeeds'] = $helper->checkForLocalFeeds();

        if (!$viewData['localFeeds']) {
            $viewData['remoteFeeds'] = $helper->checkForUpdates();
        }

        return view('template_v2.misc.library_thing.tags', $viewData);
    }
}
