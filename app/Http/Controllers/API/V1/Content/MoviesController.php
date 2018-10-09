<?php

namespace App\Http\Controllers\API\V1\Content;

use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ingestion\Rabbitmq\Indexation;

/**
 * Class MoviesController
 * @package App\Http\Controllers\API\V1\Content
 */
class MoviesController extends Controller
{
    /**
     * @param Request $request
     * @param Indexation $indexation
     * @return \Illuminate\Http\JsonResponse
     */
    public function setStatus(Request $request, Indexation $indexation)
    {
        $id = $request->id;
        $result = Movie::where('id', $id)->update(['status' => $request->status]);
        $indexation->push('updateSingle', 'movies', $id);

        return response()->json(['result' => $result], 200);
    }
}
