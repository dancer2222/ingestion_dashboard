<?php

namespace App\Http\Controllers\API\V1\Content;

use App\Models\Album;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class AlbumsController
 * @package App\Http\Controllers\API\V1\Content
 */
class AlbumsController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setStatus(Request $request)
    {
        $result = Album::where('id', $request->id)->update(['status' => $request->status]);

        return response()->json(['result' => $result], 200);
    }
}
