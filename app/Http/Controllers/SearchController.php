<?php

namespace App\Http\Controllers;

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
     * Allowed content types
     */
    const CONTENT_TYPES = [
        'movies',
        'books',
        'audiobooks',
        'albums',
        'games',
    ];

    /**
     * We can search using only these types of values
     */
    const VALUE_TYPES = [
        'movies' => ['id', 'title'],
        'books' => ['id', 'title', 'isbn'],
        'audiobooks' => ['id', 'title', 'dataOriginId', 'isbn'],
        'albums' => ['id', 'title', 'upc'],
        'games' => ['id'],
    ];

    /**
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $id = $request->value;
        $contentType = $request->contentType;

        // Declare the default values for view
        $dataForView['contentTypes'] = self::CONTENT_TYPES;
        $dataForView['contentType'] = $contentType ?? self::CONTENT_TYPES[0];
        $dataForView['valueTypes'] = self::VALUE_TYPES[$dataForView['contentType']] ?? self::VALUE_TYPES[0];
        $dataForView['valueTypesAll'] = self::VALUE_TYPES;
        $dataForView['valueType'] = $request->valueType;

        if (isset($id, $contentType)) {
            $changeStatus = new TrackingStatusChanges();
            $statusInfo = $changeStatus->getInfoById($id);

            if (!$statusInfo->isEmpty()) {
                $statusInfo->toArray();
            } else {
                $statusInfo = null;
            }

            $className = "Ingestion\Search\\" . ucfirst($contentType);

            try {
                $reflectionMethod = new \ReflectionMethod($className, 'searchInfoById');

                $data = $reflectionMethod->invoke(
                    new $className(),
                    $id,
                    $contentType,
                    GeoRestrict::search($id, $contentType),
                    $contentType
                );

                if (\is_array($data)) {
                    $dataForView = array_merge($dataForView, $data);
                }
            } catch (\Exception $exception) {
                return view('search.infoById', $dataForView)->withErrors($exception->getMessage());
            }

            $dataForView['statusInfo'] = $statusInfo;
        }

        return view('search.infoById', $dataForView);
    }
}
