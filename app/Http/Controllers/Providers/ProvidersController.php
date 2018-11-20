<?php

namespace App\Http\Controllers\Providers;

use App\Models\DataSourceProvider;
use App\Models\Audiobook;
use App\Models\Book;
use App\Models\MediaType;
use App\Models\Movie;
use App\Models\Album;
use App\Models\Game;
use App\Models\QaBatch;
use App\Models\Software;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
     * @param MediaType $mediaType
     * @param DataSourceProvider $dataSourceProvider
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(MediaType $mediaType, DataSourceProvider $dataSourceProvider, Request $request)
    {
        $data = [];
        $isList = $request->has('list');
        $isNeedle = $request->has('needle');
        $dataSourceProviderQuery = $dataSourceProvider->newQuery();

        if ($isNeedle || $isList) {
            $needle = $request->get('needle');
            $mediaTypes = $mediaType->select('media_type_id')->whereIn('title', $request->get('media_type', array_keys(self::CONTENT_MODELS_MAPPING)))->get();

            if ($needle) {
                $dataSourceProviderQuery->where('id', 'like', "%$needle%")
                    ->orWhere('name', 'like', "%$needle%");
            } else {
                $dataSourceProviderQuery->whereNotNull('name');
            }

            $data['providers'] = $dataSourceProviderQuery->select('id', 'name')
                ->whereHas('qaBatches', function ($q) use ($mediaTypes) {
                    $q->whereIn('media_type_id', $mediaTypes->pluck('media_type_id'))->distinct('data_source_provider_id');
                })->with(['qaBatch' => function ($q) {
                    $q->select('id', 'data_source_provider_id', 'media_type_id')->with('mediaType:media_type_id,title');
                }])->get();
        }

        return view('template_v2.misc.providers.index', $data);
    }

    /**
     * Display the specified resource
     *
     * @param string $mediaType
     * @param string $providerId
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(string $mediaType, string $providerId, Request $request)
    {
        $data = [];
        $data['provider'] = DataSourceProvider::find($providerId);
        $qaBatch = QaBatch::select('id')->where('data_source_provider_id', $providerId)->get();

        $contentModelName = self::CONTENT_MODELS_MAPPING[$mediaType];
        $contentModelQuery = (new $contentModelName)->newQuery();
        $contentModelQuery->whereIn('batch_id', $qaBatch->pluck('id'));

        if ($statuses = $request->get('status', [])) {
            $contentModelQuery->whereIn('status', $statuses);
        }

        if (($trackingStatuses = $request->get('status_tracking', [])) && ($trackingDate = $request->get('tracking_date'))) {
            $carbon = Carbon::parse($trackingDate);
            $startDay = $carbon->startOfMonth()->timestamp;
            $endDay = $carbon->lastOfMonth()->timestamp;

            $contentModelQuery->whereHas('statusChanges', function ($query) use ($startDay, $endDay, $trackingStatuses) {
                $query->whereIn('new_value', $trackingStatuses)
                    ->where('date_added', '>=', $startDay)
                    ->where('date_added', '<=', $endDay);
            });
        }

        $data['providerContentList'] = $contentModelQuery->paginate()->withPath(request()->fullUrl());
        $data['mediaType'] = $mediaType;
        $data['statuses'] = $statuses;
        $data['trackingStatuses'] = $trackingStatuses;
        $data['trackingDate'] = $trackingDate ?? Carbon::now()->format('Y-m-d');

        return view('template_v2.misc.providers.index', $data);
    }
}
