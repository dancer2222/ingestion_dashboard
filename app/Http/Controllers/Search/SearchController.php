<?php

namespace App\Http\Controllers\Search;

use App\Models\Contracts\SearchableModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    /**
     * @var array
     */
    private $scopesMapping = [
        'audiobooks' => ['provider', 'licensor', 'georestricts', 'qaBatch', 'statusChanges', 'blacklist', 'products'],
        'books'      => ['provider', 'licensor', 'georestricts', 'qaBatch', 'statusChanges', 'language'],
        'movies'     => ['provider', 'licensor', 'georestricts', 'qaBatch', 'statusChanges', 'brightcove'],
    ];

    /**
     * @param string $mediaType
     * @param Request $request
     * @param SearchableModel $model
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(string $mediaType, Request $request, SearchableModel $model)
    {
        $viewData['mediaType'] = $mediaType;
        
        if ($request->get('needle')) {
            $viewData['list'] = $model->seek($request->get('needle'))->paginate(15);
        }

        return view('template_v2.search.index', $viewData);
    }

    /**
     * @param string $mediaType
     * @param string $id
     * @param SearchableModel $model
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(string $mediaType, string $id, SearchableModel $model)
    {
        $viewData['mediaType'] = $mediaType;
        $viewName = "template_v2.search.{$mediaType}_item";

        if (!view()->exists($viewName)) {
            return view('template_v2.search.index', $viewData);
        }

        $viewData['item'] = $model->seekById($id, $this->scopesMapping[$mediaType]);

        return view($viewName, $viewData);
    }
}
