<?php

namespace App\Http\Controllers\Brightcove;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Brightcove;

/**
 * Class NotificationsController
 * @package App\Http\Controllers\Brightcove
 */
class NotificationsController extends Controller
{
    const STATUS_SUCCESS = 'active';
    const STATUS_FAILED = 'inactive';

    /**
     * NotificationsController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware = [
            ['middleware' => 'api', 'options' => []]
        ];
    }


    /**
     * We should get array {
     *      "accountId": "57838016001",
     *      "entityType": "ASSET",
     *      "version": "1",
     *      "status": "SUCCESS",
     *      "videoId": "5444872379001",
     *      "entity": "5444872379001"
     * }
     * Docs https://support.brightcove.com/dynamic-ingest-notifications
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request)
    {
        try {
            switch ($request->get('status')) {
                case 'FAILED':
                    $status = self::STATUS_FAILED;
                    break;
                case 'SUCCESS':
                    $status = self::STATUS_SUCCESS;
                    break;
                default:
                    throw new \Exception("Status doesn't supported.");
            }

            $brightcoves = Brightcove::whereBrightcoveId($request->get('videoId'))->get();

            foreach ($brightcoves as $movie) {
                $movie->status = $status;
                $movie->updated_at = time();
                $movie->save();
            }

            return response()->json(['message' => 'Status has been changed successfully.'])->setStatusCode(201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()])->setStatusCode(400);
        }
    }
}
