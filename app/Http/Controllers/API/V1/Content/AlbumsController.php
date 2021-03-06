<?php

namespace App\Http\Controllers\API\V1\Content;

use App\Models\Album;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ingestion\ICache\Facades\ICache;
use Ingestion\Logs\UserActivityLogs;
use Ingestion\Rabbitmq\Indexation;

/**
 * Class AlbumsController
 * @package App\Http\Controllers\API\V1\Content
 */
class AlbumsController extends Controller
{
    /**
     * @var string
     */
    private $mediaType = 'albums';

    /**
     * AlbumsController constructor.
     */
    public function __construct()
    {
        ICache::forgetContentItem($this->mediaType, request()->id);
    }

    /**
     * @param Request $request
     * @param Indexation $indexation
     * @param UserActivityLogs $userActivityLogs
     * @return \Illuminate\Http\JsonResponse
     */
    public function setStatus(Request $request, Indexation $indexation, UserActivityLogs $userActivityLogs)
    {
        $id = $request->id;

        $result = Album::where('id', $id)->update(['status' => $request->status]);

        $indexation->push('updateSingle', $this->mediaType, $id);
        $userActivityLogs->updateMediaStatus($id, $this->mediaType);

        return response()->json(['result' => $result], 200);
    }
}
