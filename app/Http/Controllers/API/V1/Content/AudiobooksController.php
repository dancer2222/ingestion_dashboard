<?php

namespace App\Http\Controllers\API\V1\Content;

use App\Models\Audiobook;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class AudiobooksController
 * @package App\Http\Controllers\API\V1\Content
 */
class AudiobooksController extends Controller
{
    /**
     * @var Audiobook
     */
    private $audiobook;

    /**
     * AudiobooksController constructor.
     * @param Request $request
     * @param Audiobook $audiobook
     */
    public function __construct(Request $request, Audiobook $audiobook)
    {
        $this->audiobook = $audiobook;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setStatus(Request $request)
    {
        $result = Audiobook::where('id', $request->id)->update(['status' => $request->status]);

        return response()->json(['result' => $result], 200);
    }
}
