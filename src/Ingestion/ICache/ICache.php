<?php

namespace Ingestion\ICache;

use Illuminate\Support\Facades\Cache;

class ICache
{
    private const PATTERN_CACHE_KEY_LIST = 'content.search.list.%media_type%.%needle%.page_%page%';
    private const PATTERN_CACHE_KEY_ITEM = 'content.%media_type%.%id%';

    /**
     * @param string $mediaType
     * @param string $needle
     * @param $page
     * @return string
     */
    public function getCacheKeySearchList(string $mediaType, string $needle, $page = 1): string
    {
        return str_replace(['%media_type%', '%needle%', '%page%'], [$mediaType, $needle, $page], self::PATTERN_CACHE_KEY_LIST);
    }

    /**
     * @param string $mediaType
     * @param $id
     * @return mixed
     */
    public function getCacheKeyItem(string $mediaType, $id)
    {
        return str_replace(['%media_type%', '%id%'], [$mediaType, $id], self::PATTERN_CACHE_KEY_ITEM);
    }

    /**
     * @param $data
     * @param string $mediaType
     * @param string $needle
     * @param int $page
     */
    public function putSearchList($data, string $mediaType, string $needle, $page = 1): void
    {
        $this->put($this->getCacheKeySearchList($mediaType, $needle, $page), $data);
    }

    /**
     * @param string $mediaType
     * @param string $needle
     * @param $page
     * @return mixed
     */
    public function getSearchList(string $mediaType, string $needle, $page)
    {
        return $this->get($this->getCacheKeySearchList($mediaType, $needle, $page), false);
    }

    /**
     * @param string $mediaType
     * @param string $needle
     * @param $page
     */
    public function forgetSearchList(string $mediaType, string $needle, $page)
    {
        $this->forget($this->getCacheKeySearchList($mediaType, $needle, $page));
    }

    /**
     * @param $data
     * @param string $mediaType
     * @param $id
     */
    public function putContentItem($data, string $mediaType, $id): void
    {
        $this->put($this->getCacheKeyItem($mediaType, $id), $data);
    }

    /**
     * @param string $mediaType
     * @param $id
     * @return mixed
     */
    public function getContentItem(string $mediaType, $id)
    {
        return $this->get($this->getCacheKeyItem($mediaType, $id), false);
    }

    /**
     * @param string $mediaType
     * @param $id
     */
    public function forgetContentItem(string $mediaType, $id)
    {
        $this->forget($this->getCacheKeyItem($mediaType, $id));
    }

    /**
     * @param string $key
     * @param $data
     */
    private function put(string $key, $data)
    {
        Cache::put($key, $data, 1000);
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed
     */
    private function get(string $key, $default = null)
    {
        return Cache::get($key, $default);
    }

    /**
     * @param string $key
     */
    private function forget(string $key)
    {
        Cache::forget($key);
    }
}
