<?php

namespace App\Http\Controllers\API\V1\Tools;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

/**
 * Class ConfigController
 * @package App\Http\Controllers\API\V1\Tools
 */
class ConfigController extends Controller
{
    /**
     * Gets all data from request and put them to file
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function store(Request $request)
    {
        $configName = config('api.ingestion.tools.config_file_name');
        $content = serialize($request->all());

        Storage::disk('local')->put("tmp/$configName", $content);

        return response('Created', 201);
    }
}
