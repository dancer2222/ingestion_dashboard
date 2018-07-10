<?php

namespace App\Http\Controllers;

use App\Models\MediaMetadata;
use App\Models\MediaType;
use Aws\S3\S3Client;
use Illuminate\Http\Request;
use Ingestion\Parse\ParseMetadata;
use Spatie\ArrayToXml\ArrayToXml;

/**
 * Class ParseController
 * @package App\Http\Controllers
 */
class ParseController extends Controller
{
    /**
     * @var string
     */
    public $filepath;

    /**
     * @var
     */
    public $dataType;

    /**
     * ParseController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->dataType = explode('.', $request->batchTitle, 2)[1];
        $downloadPath = public_path("tmp/download");

        if (!file_exists($downloadPath)) {
            mkdir($downloadPath, 0777, true);
            @chmod($downloadPath, 0777);
        }

        $this->filepath = $downloadPath . '/' . $request->batchTitle;
    }

    /**
     * @param Request $request
     * @param S3Client $awsS3
     * @param ParseMetadata $parse
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index(Request $request, S3Client $awsS3, ParseMetadata $parse)
    {
        if ($this->dataType == 'zip') {
            $message = 'This file has an extension `zip` you can look it up in: [public/' . $this->filepath . ']';

            return back()->with('message', $message);
        }

        try {

            if (!file_exists($this->filepath)) {
                $parse->download($awsS3, $request->bucket, $request->object, $this->filepath);
            }

            $result = $parse->index(
                $request->batchTitle,
                $this->dataType,
                $request->id,
                $request->title,
                $this->filepath
            );
        } catch (\Exception $exception) {
            return redirect(route('search', ['id' => $request->id, 'type' => '']))
                ->with('message', $exception->getMessage());
        }

        if ($this->dataType == 'xml' || $this->dataType == 'COT') {
            return response($result)->header('Content-Type', 'text/xml');
        } else {
            return view('search.metadata', ['messages' => $result]);
        }
    }

    /**
     * @param Request $request
     * @param MediaMetadata $metadataInfo
     * @return mixed
     */
    public function getMetadataIntoDatabase(Request $request, MediaMetadata $metadataInfo)
    {
        $metadata = $metadataInfo->getMetadata($request->id, MediaType::getIdByTitle($request->type));

        if (!is_null($metadata)) {
            $arrayMetadata = json_decode($metadata->metadata, true);

            return response(ArrayToXml::convert($arrayMetadata, 'product'))
                ->header('Content-Type', 'text/xml');
        }

        return response('This metadata not found in database')->header('Content-Type', 'text');
    }
}
