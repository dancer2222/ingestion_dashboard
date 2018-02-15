<?php

namespace Ingestion\Parse;

use Aws\S3\S3Client;
use Aws\Result;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\ArrayToXml\ArrayToXml;

/**
 * Class ParseMetadata
 * @package Ingestion\ParseMetadata
 */
class ParseMetadata
{
    /**
     * @var array
     */
    protected $shortTags;

    /**
     * @var bool
     */
    protected $isShortTags = false;

    /**
     * ParseMetadata constructor.
     */
    public function __construct()
    {
        $this->shortTags = TagList::getTagList();
    }

    /**
     * @param string $batchTitle
     * @param string $dataType
     * @param        $id
     * @param string $title
     * @param string $filepath
     *
     * @return array|null|string
     */
    public function index(string $batchTitle, string $dataType, $id, string $title, string $filepath)
    {
        $messages = null;
        if ($dataType != null) {
            switch ($dataType) {
                case 'xml':
                case 'COT':
                    $messages = $this->searchProductInXml($filepath, $id);
                    break;
                case 'xlsx':
                case 'xls':
                case 'csv':
                    $messages = $this->getFile($filepath, $title);
                    break;
                default:
                    $messages = 'Failed to define the data type in ' . $batchTitle;
            }
        }

        return $messages;
    }

    /**
     * @param S3Client $awsS3
     * @param string $bucket
     * @param string $path
     * @param string $filepath
     * @return Result
     */
    public function download(S3Client $awsS3, string $bucket, string $path, string $filepath): Result
    {
        // Get the object
        $result = $awsS3->getObject([
            'Bucket' => $bucket,
            'Key'    => $path,
            'SaveAs' => $filepath
        ]);

        @chmod($filepath, 0777);

        return $result;
    }

    /**
     * @param $filepath
     * @param $title
     *
     * @return array
     */
    public function getFile(string $filepath, string $title)
    {

        $results = Excel::load($filepath, function($reader) {
            $reader->all();
        })->get();

        $resultExcel = [];

        foreach ($results as $result => $value) {

            foreach ($value as $item) {

                if (isset($value['title'])) {
                    if ($title == $value['title']) {
                        $resultExcel [] = $value;
                    }
                } elseif (isset($item['series_name'])) {
                    $resultExcel [] = $item;
                }
            }
        }

        return array_unique($resultExcel);
    }

    /**
     * Get the tag name (this function takes the long tag name as a reference name and returns the tag used in the onix
     * version) For example if we pass a refName as NamesBeforeKey we will get NamesBeforeKey if long tags or b039 if
     * short tags
     *
     * @param string $refName the long tag name
     *
     * @return bool|mixed the tag name or false if not found
     */
    public function getTagName($refName)
    {
        if ($tagName = array_search($refName, $this->shortTags)) {
            return $tagName;
        }

        return false;
    }

    /**
     * @param $filepath
     * @param $id
     *
     * @return string
     */
    public function searchProductInXml($filepath, $id)
    {
        $messages = [];

        try {

            $xml = simplexml_load_file($filepath);
        } catch (\Exception $exception) {

            return $exception->getMessage();
        }

        $idByBucket = explode(1000, $id)[1];
        foreach ($xml as $value) {
            if ($value->{$this->getTagName('ProductIdentifier')}->IDValue == $idByBucket
                or $value->{$this->getTagName('RecordReference')} == $idByBucket
                or $value->{$this->getTagName('ProductIdentifier')}->b244 == $idByBucket) {
                $messages [] = $value;
            }
        }

        $json = json_encode($messages[0]);
        $array = json_decode($json, true);
        $result = ArrayToXml::convert($array, 'product');

        return $result;
    }
}