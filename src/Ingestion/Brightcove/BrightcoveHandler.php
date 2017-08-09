<?php

namespace Ingestion\Brightcove;

use Illuminate\Http\Request;
use Ingestion\Brightcove\Api\CMS;

class BrightcoveHandler
{
    /**
     * @var CMS
     */
    private $cms;

    /**
     * Contain prepared parameters to build query to call API
     *
     * @var array
     */
    private $preparedParams = [];

    /**
     * The main query that will be passed to base CMS
     *
     * @var string
     */
    private $query = '';

    /**
     * @var string
     */
    private $queryFromRequest = '';

    /**
     * The parameters which are injected into construct
     *
     * @var array
     */
    private $paramsFromRequest = [];

    /**
     * They're set when we use method BrightcoveHandler::bindParams to build query
     *
     * @var array
     */
    private $paramsCustom = [];

    /**
     * BrightcoveHandler constructor.
     * Set CMS and array the passed parameters to build query
     *
     * @param CMS $cms
     * @param Request $request
     */
    public function __construct(CMS $cms, Request $request)
    {
        $this->cms = $cms ?: null;
        $this->paramsFromRequest = $request->all();
        $this->setQuery();
    }

    /**
     * Handle all the passed params
     * We take only these params: q, limit, offset, page
     *
     * @return void
     */
    private function prepareParams(): void
    {
        $this->preparedParams = [];
        $params = $this->paramsCustom ?: $this->paramsFromRequest;

        if (isset($params['q'])) {
            // TODO: In future we could define the available values for this parameter and validate them.
            // Read more about it: https://support.brightcove.com/cmsplayback-api-videos-search#combinesearchcriteria
            $this->preparedParams['q'] = $params['q'] ?: '';
        }

        if (isset($params['limit'])) {
            // By default the limit is set to 20
            $this->preparedParams['limit'] = $params['limit'] ?: 20;
        }

        if (isset($params['offset'])) {
            // By default the offset is set to 0
            $this->preparedParams['offset'] = $params['offset'] ?: 0;
        }

        if (isset($params['page'])) {
            // We don't use the parameter 'page' to call API,
            // we need it only to set right offset if the page is passed
            $this->preparedParams['offset'] = $this->calculateOffset((int)$params['page'] ?: 1);
        }
    }

    /**
     * Calculate the offset param
     *
     * @param integer $page
     * @return int
     */
    private function calculateOffset(int $page): int
    {
        $limit = $this->getLimit();

        return ($page * $limit) - $limit;
    }

    /**
     * Returns the parameter 'limit'
     *
     * @return int
     */
    private function getLimit(): int
    {
        if (isset($this->preparedParams['limit']) && $this->preparedParams['limit'] > 0) {
            return (int)$this->preparedParams['limit'];
        }

        return 20;
    }

    /**
     * Build the query from the prepared parameters
     *
     * @return string
     */
    private function buildQuery(): string
    {
        // If method BrightcoveHandler::bindParams isn't called
        // we return the query that was built when object was initialized
        if ($this->queryFromRequest && !$this->paramsCustom) {
            return $this->queryFromRequest;
        }

        $this->prepareParams();

        if (!$this->preparedParams) {
            return '';
        }

        // Make query from the prepared parameters which are prepared by BrightcoveHandler::prepareParams
        $query = '?';

        foreach ($this->preparedParams as $name => $value) {
            $query .= sprintf('%s=%s&', $name, $value); // foo=bar&
        }

        $this->paramsCustom = [];

        return rtrim($query, '&'); // Remove the symbol '&' at the end of string
    }

    /**
     * Set query
     *
     * @return void
     */
    private function setQuery(): void
    {
        $this->query = $this->buildQuery();
    }

    /**
     * Invoke this method if you need to set the custom parameters to call API
     *
     * @param array $params
     * @return $this
     */
    public function bindParams(array $params): self
    {
        $this->paramsCustom = $params;
        $this->setQuery();

        return $this;
    }

    /**
     * Returns the prepared parameters
     *
     * @return array
     */
    public function getPreparedParams(): array
    {
        return $this->preparedParams;
    }

    /**
     * Returns the query
     *
     * @return string
     */
    public function getQuery(): string
    {
        return $this->query;
    }

    /**
     * Returns amount of pages
     *
     * @param int|null $videos Amount of movies
     * @return float
     */
    public function getPages(int $videos = NULL): float
    {
        $amountVideos = $videos ?: $this->cms->countVideos($this->query);

        return ceil($amountVideos / $this->getLimit()) ?: 1;
    }

    /**
     * Returns amount of videos
     *
     * @return mixed
     */
    public function countVideos()
    {
        return $this->cms->countVideos($this->query);
    }

    /**
     * Returns videos
     *
     * @return \Brightcove\Object\ObjectInterface|\Brightcove\Object\ObjectInterface[]|null
     */
    public function getVideos()
    {
        return $this->cms->getVideos($this->query);
    }

    /**
     * Returns folders
     *
     * @return \Brightcove\Object\ObjectInterface|\Brightcove\Object\ObjectInterface[]|null
     */
    public function getFolders()
    {
        return $this->cms->getFolders($this->query);
    }

    /**
     * Returns information about the folder
     *
     * @param $id
     * @return \Brightcove\Object\ObjectInterface|\Brightcove\Object\ObjectInterface[]|null
     */
    public function getFolderInfo($id)
    {
        return $this->cms->getFolderInformation($id);
    }

    /**
     * Returns videos from the folder
     *
     * @param $id
     * @return \Brightcove\Object\ObjectInterface|\Brightcove\Object\ObjectInterface[]|null
     */
    public function getVideosInFolder($id)
    {
        return $this->cms->getVideosInFolder($id, $this->query);
    }
}