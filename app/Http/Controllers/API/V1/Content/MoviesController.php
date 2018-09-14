<?php

namespace App\Http\Controllers\API\V1\Content;

use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class MoviesController
 * @package App\Http\Controllers\API\V1\Content
 */
class MoviesController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setStatus(Request $request)
    {
        $result = Movie::where('id', $request->id)->update(['status' => $request->status]);

        return response()->json(['result' => $result], 200);
    }
}
