<?php

namespace App\Http\Controllers;

use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\ArrayToXml\ArrayToXml;


class ExcelController extends Controller
{
    /**
     * @var array list of short tags mapped to long tags
     */
    protected $shortTags;

    /**
     * @var bool true if the type of tags in the onix is short (for example b036 is a short tag because it's a code no a full name) false if the type is long
     */
    protected $isShortTags = false;

    public function __construct()
    {
        $this->shortTags = TagListController::getTagList();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $bucket = $request->bucket;
        $object = $request->object;
        $id = $request->id;
        $batchTitle = $request->batchTitle;
        $title = $request->title;
        $filepath = "download/$batchTitle";
        $dataType = explode('.',$batchTitle, 2)[1];

        $s3 = new S3Client([
            'version' => 'latest',
            'region' => 'us-east-1',
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        if (!file_exists($filepath)) {
            try {
                // Get the object
                $s3->getObject(array(
                    'Bucket' => $bucket,
                    'Key'    => $object,
                    'SaveAs' => $filepath
                ));

            } catch (S3Exception $e) {
                unlink($filepath);
                $messages =  $e->getMessage();
                return redirect(action('SearchController@index', ['id' => $id]))->with('message', $messages);
            }
        }

        @chmod($filepath, 0777);
        if ($dataType != null){
            switch ($dataType) {
                case 'xml':
                    $messages = [];
                    $xml = simplexml_load_file($filepath);
                    $idByBucket = explode(1000,$id)[1];
                    foreach ($xml as $value)
                    {
                        if ($value->{$this->getTagName('ProductIdentifier')}->IDValue == $idByBucket
                            or $value->{$this->getTagName('RecordReference')} == $idByBucket) {
                            $messages []= $value;
                        }
                    }
                    $json = json_encode($messages[0]);
                    $array = json_decode($json,TRUE);
                    $result = ArrayToXml::convert($array);

                    return response($result);

                case 'zip':
                    $messages = 'This file has an extension `zip` you can look it up in: [public/'.$filepath.']';
                    return response($messages);
                case 'xlsx':
                    $messages =$this->getFile($filepath, $title);
                    return view('search.metadata', ['messages' => $messages]);
                case 'csv':
                    $messages =$this->getFile($filepath, $title);
                    return view('search.metadata', ['messages' => $messages]);
                default:
                    $message = 'Failed to define the data type in '. $batchTitle;
                    return redirect(action('SearchController@index', ['id' => $id]))->with('message', $message);
            }
        }

        return redirect(action('SearchController@index', ['id' => $id]));
    }

    /**
     * @param $filepath
     * @param $title
     * @return array
     */
    public function getFile($filepath, $title)
    {

       $results = Excel::load($filepath, function ($reader) {
          $reader->all();
       })->get();
       $resultExcel = [];

        foreach ($results as $result => $value) {
            foreach ($value as $item) {
                    if (isset($value['title'])){
                        if ($title == $value['title']) {
                            $resultExcel []= $value;
                        }
                    } elseif (isset($item['series_name'])){
                        if ($title == $item['series_name']){
                            $resultExcel []= $item;
                        }
                    }
                }
            }

       return $resultExcel;
    }

    /**
     * Get the tag name (this function takes the long tag name as a reference name and returns the tag used in the onix version)
     * For example if we pass a refName as NamesBeforeKey we will get NamesBeforeKey if long tags or b039 if short tags
     *
     * @param string $refName the long tag name
     * @return bool|mixed the tag name or false if not found
     */
    public function getTagName($refName)
    {
        if ($tagName = array_search($refName, $this->shortTags)) {
            return $tagName;
        }

        return false;
    }
}
