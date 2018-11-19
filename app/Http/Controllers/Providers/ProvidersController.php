<?php

namespace App\Http\Controllers\Providers;

use App\Models\DataSourceProvider;
use App\Models\Audiobook;
use App\Models\Book;
use App\Models\Movie;
use App\Models\Album;
use App\Models\Game;
use App\Models\QaBatch;
use App\Models\Software;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Ingestion\Exports\Csv\LicensorsContent;

class ProvidersController extends Controller
{
    const CONTENT_MODELS_MAPPING = [
        'audiobooks' => Audiobook::class,
        'books' => Book::class,
        'movies' => Movie::class,
        'albums' => Album::class,
        'games' => Game::class,
        'software' => Software::class,
    ];

    /**
     * Display providers list or blank form.
     *
     * @param DataSourceProvider $provider
     * @return \Illuminate\Http\Response
     */
    public function index(DataSourceProvider $provider, Request $request)
    {
        return view('template_v2.misc.providers.index', []);
    }

    /**
     * @param DataSourceProvider $provider
     * @param Request $request
     * @return JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function search(DataSourceProvider $provider, Request $request)
    {
        if (!$request->ajax()) {
            return redirect()->route('providers.index');
        }

        $data = [];
        $isList = request()->has('list');
        $needle = request()->get('needle');
        $providerQuery = $provider->newQuery();


        if (!$isList && $needle) {
            $data = $providerQuery->where('id', 'like', "%$needle%")
                ->orWhere('name', 'like', "%$needle%")
                ->with(['qaBatch' => function ($query) {
                    $query->select('media_type_id', 'data_source_provider_id')
                        ->with('mediaType:title,media_type_id');
                }])->get();
        }

        if ($isList && !$needle) {
            $data = $providerQuery->with(['qaBatch' => function ($query) {
                $query->select('media_type_id', 'data_source_provider_id')
                    ->with('mediaType:title,media_type_id')
                    ->distinct('data_source_provider_id');
            }])->get();
        }

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param int $providerId
     * @param DataSourceProvider $provider
     * @return \Illuminate\Http\Response
     */
    public function searchOne($providerId, Request $request, DataSourceProvider $provider)
    {
        $data = [];

        if (!$request->ajax()) {
            return view('template_v2.misc.providers.index', []);
        }

        $provider = $provider->find($providerId);
        $mediaType = $request->get('media_type', false);

        if (!$provider) {
            return response()->json(['error' => "Can't find provider with id: $providerId"]);
        }

        if (!$mediaType) {
            $qaBatchWithMediaType = QaBatch::select('id', 'media_type_id')
                ->where('data_source_provider_id', $providerId)
                ->whereNotNull('data_source_provider_id')
                ->whereNotNull('media_type_id')
                ->has('mediaType')
                ->with(['mediaType'])
                ->first();

            if (!$qaBatchWithMediaType || !$qaBatchWithMediaType->mediaType || !($mediaType = $qaBatchWithMediaType->mediaType->title)) {
                return response()->json(['error' => "Can't determine provider media type."]);
            }

            $mediaType = $qaBatchWithMediaType->mediaType->title;
        }

        $data['mediaType'] = $mediaType;

        $modelName = self::CONTENT_MODELS_MAPPING[$mediaType];
        $model = new $modelName;

        $data['list'] = $model->where('status', 'active')
            ->whereHas('provider', function ($query) use ($providerId) {
                $query->where($query->getModel()->getTable() . '.id', $providerId);
            })->with('provider')->paginate();

        $data['provider'] = $provider;

        return response()->json($data);
    }

    /**
     * Display the specified resource specified date.
     *
     * @param int $providerId
     * @param int $mediaTypeId
     * @param date $date
     * @param DataSourceProvider $provider
     * @return \Illuminate\Http\Response
     */
    public function trackingStatus($providerId, $mediaTypeId, $date, Request $request, DataSourceProvider $provider)
    {
        $date = Carbon::parse($date);
        $startDay = $date->startOfMonth()->timestamp;
        $endDay = $date->lastOfMonth()->timestamp;

        $modelName = self::CONTENT_MODELS_MAPPING[$mediaTypeId];
        $model = new $modelName;
        $data['list'] = $model->whereHas('provider', function ($query) use ($providerId) {
                $query->where($query->getModel()->getTable() . '.id', $providerId);
            })->whereHas('statusChanges', function ($query) use ($startDay, $endDay) {
            $query->where('new_value', 'active')->where('date_added', '>=', $startDay)->where('date_added', '<=', $endDay);
        })->with('provider')->paginate();
    }
}
