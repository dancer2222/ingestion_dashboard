<?php

namespace App\Http\Controllers\Search;

use App\Models\Contracts\SearchableModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

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
     * @var string
     */
    private $cacheKeyPrefix;

    /**
     * SearchController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->cacheKeyPrefix = $request->route()->getName();
    }

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
        $cacheKey = "{$this->cacheKeyPrefix}.$mediaType.$needle.page_$page";
        $viewData['mediaType'] = $mediaType;

        if ($needle) {
            if (!($data = Cache::get($cacheKey))) {
                $data = $model->seek($needle, ['licensor:id,name'])->paginate(15);

                Cache::put($cacheKey, $data, 1000);
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
        $cacheKey = "{$this->cacheKeyPrefix}.$mediaType.$id";

        if (!($data = Cache::get($cacheKey))) {
            $data = $model->seekById($id, $scopes);

            Cache::put($cacheKey, $data, 1000);
        }

        $viewData['item'] = $data;

        return view($viewName, $viewData);
    }
}
