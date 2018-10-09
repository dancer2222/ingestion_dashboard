<?php

namespace App\Http\Controllers\API\V1\Content;

use App\Models\Album;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ingestion\Rabbitmq\Indexation;

/**
 * Class AlbumsController
 * @package App\Http\Controllers\API\V1\Content
 */
class AlbumsController extends Controller
{
    /**
     * @param Request $request
     * @param Indexation $indexation
     * @return \Illuminate\Http\JsonResponse
     */
    public function setStatus(Request $request, Indexation $indexation)
    {
        $id = $request->id;
        $result = Album::where('id', $id)->update(['status' => $request->status]);
        $indexation->push('updateSingle', 'albums', $id);

        return response()->json(['result' => $result], 200);
    }
}
