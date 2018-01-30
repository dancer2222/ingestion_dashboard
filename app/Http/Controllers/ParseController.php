<?php

namespace App\Http\Controllers;

use Aws\S3\S3Client;
use Illuminate\Http\Request;
use Ingestion\ParseMetadata\Parse;


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
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        try {
           $this->dataType = explode('.', $request->batchTitle, 2)[1];
           $this->filepath = "download/$request->batchTitle";
        } catch (\Exception $exception) {

            return redirect(action('SearchController@index', ['id' => $request->id, 'type' => '']))->with('message',
                $exception->getMessage());
        }

        return false;
    }

    public function index(Request $request, S3Client $awsS3)
    {
        if ($this->dataType == 'zip') {
            $message = 'This file has an extension `zip` you can look it up in: [public/' . $this->filepath . ']';

            return back()->with('message', $message);
        }

        try {
            $parse = new Parse();
            $parse->download($awsS3, $request->bucket, $request->object, $this->filepath, $request->id);
            $result = $parse->index($request->batchTitle, $this->dataType, $request->id, $request->title, $this->filepath);

        } catch (\Exception $exception) {

            return redirect(action('SearchController@index', ['id' => $request->id, 'type' => '']))->with('message',
                $exception->getMessage());
        }

        if ($this->dataType == 'xml' or $this->dataType == 'COT') {

            return response($result)->header('Content-Type', 'text/xml');

        } else {

            return view('search.metadata', ['messages' => $result]);
        }
    }
}
