<?php

namespace App\Http\Controllers\Search;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ingestion\Search\Contracts\SearchableEntity;

class SearchController extends Controller
{
    /**
     * @param string $mediaType
     * @param Request $request
     * @param SearchableEntity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(string $mediaType, Request $request, SearchableEntity $entity)
    {
        $viewData['mediaType'] = $mediaType;
        
        if ($request->get('needle')) {
            $viewData['list'] = $entity->search($request->get('needle'))->paginate(15);
        }

        return view('template_v2.search.index', $viewData);
    }

    /**
     * @param string $mediaType
     * @param string $id
     * @param SearchableEntity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(string $mediaType, string $id, SearchableEntity $entity)
    {
        $viewData['mediaType'] = $mediaType;
        $viewName = "template_v2.search.{$mediaType}_item";

        if (!view()->exists($viewName)) {
            return view('template_v2.search.index', $viewData);
        }

        $viewData['item'] = $entity->getModel()->find($id);

        return view($viewName, $viewData);
    }
}
