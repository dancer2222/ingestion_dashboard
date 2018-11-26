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
use App\Models\TrackingStatusChanges;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class ProvidersController
 * @package App\Http\Controllers\Providers
 */
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
        $dataSourceProviderQuery = $dataSourceProvider->newQuery();

        if ($request->has('needle') || $request->has('media_type')) {
            $needle = $request->get('needle', '');
            $mediaTypes = $mediaType->select('media_type_id', 'title')->whereIn('title', $request->get('media_type', array_keys(self::CONTENT_MODELS_MAPPING)))->get();

            if ($needle) {
                $dataSourceProviderQuery->where('id', 'like', "%$needle%")
                    ->orWhere('name', 'like', "%$needle%");
            } else {
                $dataSourceProviderQuery->whereNotNull('name');
            }

            $data['media_types'] = $mediaTypes;
            $data['providers'] = $dataSourceProviderQuery->select('id', 'name')
                ->whereHas('qaBatches', function ($q) use ($mediaTypes) {
                    $q->whereIn('media_type_id', $mediaTypes->pluck('media_type_id'))->distinct('data_source_provider_id');
                })->with(['qaBatch' => function ($q) {
                    $q->select('id', 'data_source_provider_id', 'media_type_id');
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
        $contentActiveModelQuery = (new $contentModelName)->newQuery();
        $contentInactiveModelQuery = (new $contentModelName)->newQuery();

        $contentInactiveModelQuery->whereIn('batch_id', $qaBatch->pluck('id'));
        $contentActiveModelQuery->whereIn('batch_id', $qaBatch->pluck('id'));
        
        $data['providerActiveContent'] = $contentActiveModelQuery->where('status', 'active')->count();
        $data['providerInactiveContent'] = $contentInactiveModelQuery->where('status', 'inactive')->count();
        $data['mediaType'] = $mediaType;

        return view('template_v2.misc.providers.index', $data);
    }

    /**
     * @param string $mediaType
     * @param string $providerId
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showTrackingStatusChanges(string $mediaType, string $providerId, Request $request)
    {
        $data = [];
        $mediaTypeId = MediaType::select('media_type_id')->where('title', $mediaType)->first();
        $qaBatch = QaBatch::select('id')->where('data_source_provider_id', $providerId)->get();
        $qaBatchIds = $qaBatch->pluck('id');

        $contentModelName = self::CONTENT_MODELS_MAPPING[$mediaType];
        $contentModel = new $contentModelName;
        $contentModelTable = $contentModel->getTable();

        $trackingStatusChanges = new TrackingStatusChanges;
        $trackingStatusChangesTable = $trackingStatusChanges->getTable();
        $contentActiveModelQuery = $trackingStatusChanges->newQuery();
        $contentInactiveModelQuery = $trackingStatusChanges->newQuery();

        $dateAfter = Carbon::parse($request->get('date_after'));
        $dateBefore = Carbon::parse($request->get('date_before'));

        // Count all active items
        $contentActiveModelQuery->leftJoin($contentModel->getTable(), function ($join) use ($trackingStatusChangesTable, $contentModelTable) {
                $join->on("$trackingStatusChangesTable.media_id", '=', "$contentModelTable.id");
            })
            ->leftJoin('qa_batches', function ($j) use ($contentModelTable) {
                $j->on("$contentModelTable.batch_id", '=', 'qa_batches.id');
            })
            ->where("qa_batches.data_source_provider_id", $providerId)
            ->where('new_value', 'active')
            ->where("$trackingStatusChangesTable.date_added", '>=', $dateAfter->timestamp)
            ->where("$trackingStatusChangesTable.date_added", '<=', $dateBefore->timestamp)
            ->where("$trackingStatusChangesTable.media_type_id", $mediaTypeId->media_type_id)
            ->distinct();

        // Count all inactive items
        $contentInactiveModelQuery->leftJoin($contentModel->getTable(), function ($join) use ($trackingStatusChangesTable, $contentModelTable) {
                $join->on("$trackingStatusChangesTable.media_id", '=', "$contentModelTable.id");
            })
            ->leftJoin('qa_batches', function ($j) use ($contentModelTable) {
                $j->on("$contentModelTable.batch_id", '=', 'qa_batches.id');
            })
            ->where("qa_batches.data_source_provider_id", $providerId)
            ->where('new_value', 'inactive')
            ->where("$trackingStatusChangesTable.date_added", '>=', $dateAfter->timestamp)
            ->where("$trackingStatusChangesTable.date_added", '<=', $dateBefore->timestamp)
            ->where("$trackingStatusChangesTable.media_type_id", $mediaTypeId->media_type_id)
            ->distinct();

        // dd() below is for debug
        //dd(implode(', ', $qaBatchIds->toArray()), $dateAfter->timestamp, $dateBefore->timestamp, $mediaTypeId->media_type_id, $contentActiveModelQuery->toSql());

        $data['activeContent'] = $contentActiveModelQuery->count("$contentModelTable.id");
        $data['inactiveContent'] = $contentInactiveModelQuery->count("$contentModelTable.id");

        return view('template_v2.misc.providers.tracking_status_changes_ajax', $data);
    }
}
