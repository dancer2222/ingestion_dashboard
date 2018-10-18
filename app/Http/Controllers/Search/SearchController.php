<?php

namespace App\Http\Controllers\Search;

use App\Models\Contracts\SearchableModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ingestion\ICache\Facades\ICache;

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
    private $generalScopesMapping = [
        'provider',
        'licensor:id,name',
        'georestricts:media_id,country_code,status',
        'qaBatch:id,data_source_provider_id,import_date,title',
        'statusChanges:id,media_id,old_value,new_value,date_added',
        'failedItems',
    ];

    /**
     * @param string $mediaType
     * @param Request $request
     * @param SearchableModel $model
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(string $mediaType, Request $request, SearchableModel $model)
    {
        $page = $request->get('page', 1);
        $needle = $request->get('needle');
        $viewData['mediaType'] = $mediaType;

        if ($needle) {
            if (!($data = ICache::getSearchList($mediaType, $needle, $page))) {
                $data = $model->seek($needle, ['licensor:id,name'])->paginate(15);

                ICache::putSearchList($data, $mediaType, $needle, $page);
            }

            $viewData['list'] = $data;
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

        if (!($data = ICache::getContentItem($mediaType, $id))) {
            $data = $model->seekById($id, $scopes);

            ICache::putContentItem($data, $mediaType, $id);
        }

        $viewData['item'] = $data;

        return view($viewName, $viewData);
    }
}
