<?php

namespace Ingestion\ICache\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void putSearchList($data, string $mediaType, string $needle, $page = 1)
 * @method static mixed getSearchList(string $mediaType, string $needle, $page)
 * @method static void putContentItem($data, string $mediaType, $id)
 * @method static mixed getContentItem(string $mediaType, $id)
 * @method static mixed forgetSearchList(string $mediaType, string $needle, $page)
 * @method static mixed forgetContentItem(string $mediaType, $id)
 *
 * Class ICache
 * @package Ingestion\ICache\Facades
 */
class ICache extends Facade
{
    /**
     * @inheritdoc
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'icache';
    }
}
