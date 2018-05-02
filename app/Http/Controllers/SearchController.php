<?php

namespace App\Http\Controllers;

use App\Models\MediaMetadata;
use App\Models\MediaType;
use App\Models\TrackingStatusChanges;
use Illuminate\Http\Request;
use Ingestion\Search\GeoRestrict;

/**
 * Class SearchController
 * @package App\Http\Controllers
 */
class SearchController extends Controller
{
    /**
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if (isset($request->id) && isset($request->type)) {
            $metadataInfo = new MediaMetadata();
            $metadata = $metadataInfo->getMetadata($request->id, MediaType::getIdByTitle($request->type));
            if (!is_null($metadata)) {
                $metadata = json_decode($metadata->toArray()['metadata']);
            }

            $changeStatus = new TrackingStatusChanges();
            $statusInfo = $changeStatus->getInfoById($request->id);

            if (!$statusInfo->isEmpty()) {
                $statusInfo->toArray();
            } else {
                $statusInfo = null;
            }

            $className = "Ingestion\Search\\" . ucfirst($request->type);

            try {
                $reflectionMethod = new \ReflectionMethod($className, 'searchInfoById');
            } catch (\ReflectionException $exception) {
                return view('search.infoById')->withErrors($exception->getMessage());
            }

            try {
                $dataForView = $reflectionMethod->invoke(
                    new $className(),
                    $request->id,
                    $request->type,
                    GeoRestrict::search($request->id, $request->type),
                    $request->type
                );
            } catch (\Exception $exception) {
                return view('search.infoById')->withErrors($exception->getMessage());
            }

            $dataForView['option'] = $request->option;
            $dataForView['statusInfo'] = $statusInfo;
            $dataForView['metadata'] = $metadata;

            return view('search.infoById', $dataForView);
        }

        return view('search.infoById');
    }
}
