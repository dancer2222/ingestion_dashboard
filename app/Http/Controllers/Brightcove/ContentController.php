<?php

namespace App\Http\Controllers\Brightcove;

use App\Http\Controllers\Controller;
use Ingestion\Brightcove\BrightcoveHandler;
use Ingestion\Brightcove\Api\CMS;
use Brightcove\API\Exception\APIException;
use Exception;
use Illuminate\Http\Request;

/**
 * Class ContentController
 * @package App\Http\Controllers\Brightcove
 */
class ContentController extends Controller
{
    /**
     * Show index page
     *
     * @param BrightcoveHandler $handler
     * @return \Illuminate\View\View
     */
    public function index(BrightcoveHandler $handler)
    {
        try {
            $pending = $handler->bindParams(['q' => CMS::STATE_PENDING])->countVideos();
            $inactive = $handler->bindParams(['q' => CMS::STATE_INACTIVE])->countVideos();
            $active = $handler->bindParams(['q' => CMS::STATE_ACTIVE])->countVideos();
            $incomplete = $handler->bindParams(['q' => CMS::STATE_INCOMPLETE])->countVideos();

            $data = [
                'brightcove' => [
                    'pending' => ['q' => CMS::STATE_PENDING, 'amount' => $pending],
                    'inactive' => ['q' => CMS::STATE_INACTIVE, 'amount' => $inactive],
                    'active' => ['q' => CMS::STATE_ACTIVE, 'amount' => $active],
                    'incomplete' => ['q' => CMS::STATE_INCOMPLETE, 'amount' => $incomplete],
                ],
            ];
        } catch (APIException $e) {
            $data = ['error_message' => $e->getMessage()];
        }

        return view('index', $data);
    }

    /**
     * Show page of videos
     *
     * @param Request $request
     * @param BrightcoveHandler $handler
     * @return \Illuminate\View\View
     */
    public function videos(Request $request, BrightcoveHandler $handler)
    {
        try {
            $data = [
                'videos' => $handler->getVideos(),
                'pages' => $handler->getPages(),
                'request' => $request->all(),
            ];
        } catch (Exception $e) {
            $data = ['error_message' => $e->getMessage()];
        }

        return view('video-list', $data);
    }

    /**
     * Show folders page
     *
     * @param BrightcoveHandler $handler
     * @return \Illuminate\View\View
     */
    public function folders(BrightcoveHandler $handler)
    {
        try {
            $data = [
                'folders' => array_chunk($handler->getFolders(), 10),
            ];
        } catch (APIException $e) {
            $data = ['error_message' => $e->getMessage()];
        }

        return view('folders', $data);
    }

    /**
     * Show videos from the current folder
     *
     * @param Request $request
     * @param BrightcoveHandler $handler
     * @param $id
     * @return \Illuminate\View\View
     */
    public function folder(Request $request, BrightcoveHandler $handler, $id)
    {
        try {
            $folderInfo = $handler->getFolderInfo($id);

            $data = [
                'folderName' => $folderInfo['name'],
                'videos' => $handler->getVideosInFolder($id),
                'pages' => $handler->getPages($folderInfo['video_count']),
                'request' => $request->all(),
            ];
        } catch (APIException $e) {
            $data = ['error_message' => $e->getMessage()];
        }

        return view('videos-in-folder', $data);
    }
}
