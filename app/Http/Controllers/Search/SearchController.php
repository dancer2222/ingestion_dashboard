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
        'audiobooks' => [
            'blacklist',
            'products:id,data_source_provider_id,title,isbn,modified_date,price,sale_start_date,sale_end_date,active_date,inactive_date,currency,status',
        ],
        'books'      => ['blacklist', 'languages'],
        'movies'     => ['brightcove'],
        'albums'     => [],
    ];

    /**
     * @var array
     */
    private $generalScopesMapping = [];

    /**
     * SearchController constructor.
     */
    public function __construct()
    {
        $this->generalScopesMapping = [
            'provider',
            'licensor:id,name',
            'georestricts:media_id,country_code,status',
            'qaBatch:id,data_source_provider_id,import_date,title',
            'statusChanges:id,old_value,new_value,date_added',
            'failedItems:id,reason,time,level,error_code,status',
        ];
    }

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
            $viewData['list'] = $model->seek($request->get('needle'), ['licensor:id,name'])->paginate(15);
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

        $scopes = array_merge($this->scopesMapping[$mediaType], $this->generalScopesMapping);

        $viewData['item'] = $model->seekById($id, $scopes);

        return view($viewName, $viewData);
    }
}
