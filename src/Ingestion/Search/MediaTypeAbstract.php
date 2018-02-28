<?php

namespace Ingestion\Search;

use Illuminate\Database\Eloquent\Collection;
use Exception;

/**
 * Class MediaTypeAbstract
 * @package Ingestion\Search
 */
abstract class MediaTypeAbstract
{
    /**
     * @param Collection $collection
     * @param $id
     * @param string $mediaTypeTitle
     * @return array
     * @throws Exception
     */
    protected function toArray(Collection $collection, $id, string $mediaTypeTitle) : array
    {
        if ($collection->isEmpty()) {

            $message = 'This [id] = ' . $id . '  not found in '.$mediaTypeTitle.' database';

            throw new Exception($message);
        } else {
            return  $collection[0]->toArray();
        }
    }
}