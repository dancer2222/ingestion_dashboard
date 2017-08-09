<?php

namespace Ingestion\Brightcove\Api;

use Brightcove\API\Client;
use Brightcove\API\CMS as BaseCMS;

/**
 * Class CMS
 * @package Ingestion\Brightcove\Api
 */
class CMS extends BaseCMS
{
    const STATE_PENDING = 'state:PENDING';
    const STATE_ACTIVE = 'state:ACTIVE';
    const STATE_INACTIVE = 'state:INACTIVE';
    const STATE_INCOMPLETE = 'complete:false';

    /**
     * CMS constructor.
     *
     * @param Client $client
     * @param $account
     */
    public function __construct(Client $client, $account)
    {
        parent::__construct($client, $account);
    }

    /**
     * Docs https://brightcovelearning.github.io/Brightcove-API-References/cms-api/v1/doc/index.html#api-folderGroup-Get_Folders
     *
     * @param string $query
     * @return \Brightcove\Object\ObjectInterface|\Brightcove\Object\ObjectInterface[]|null
     */
    public function getFolders($query)
    {
        return $this->cmsRequest('GET', "/folders{$query}", NULL);
    }

    /**
     * Docs https://brightcovelearning.github.io/Brightcove-API-References/cms-api/v1/doc/index.html#api-folderGroup-Get_Videos_in_Folder
     *
     * @param $id
     * @param string $query
     * @return \Brightcove\Object\ObjectInterface|\Brightcove\Object\ObjectInterface[]|null
     */
    public function getVideosInFolder($id, string $query)
    {
        return $this->cmsRequest('GET', "/folders/{$id}/videos{$query}", NULL);
    }

    /**
     * Docs https://brightcovelearning.github.io/Brightcove-API-References/cms-api/v1/doc/index.html#api-folderGroup-Get_Videos_in_Folder
     *
     * @param string $providerId
     * @param string $query
     * @return \Brightcove\Object\ObjectInterface|\Brightcove\Object\ObjectInterface[]|null
     */
    public function listVideosInFolder($providerId, string $query)
    {
        return $this->cmsRequest('GET', "/folders/{$providerId}/videos{$query}", NULL);
    }

    /**
     * Docs https://brightcovelearning.github.io/Brightcove-API-References/cms-api/v1/doc/index.html#api-videoGroup-Get_Videos
     *
     * @param string $query
     * @return \Brightcove\Object\ObjectInterface|\Brightcove\Object\ObjectInterface[]|null
     */
    public function getVideos(string $query)
    {
        return $this->cmsRequest('GET', "/videos{$query}", NULL);
    }

    /**
     * Get folder information
     * Doc https://brightcovelearning.github.io/Brightcove-API-References/cms-api/v1/doc/index.html#api-folderGroup-Get_FolderInformation
     *
     * @param $id
     * @return \Brightcove\Object\ObjectInterface|\Brightcove\Object\ObjectInterface[]|null
     */
    public function getFolderInformation($id)
    {
        return $this->cmsRequest('GET', "/folders/{$id}", NULL);
    }

    /**
     * Returns the amount of a searched video's result.
     * Docs https://brightcovelearning.github.io/Brightcove-API-References/cms-api/v1/doc/index.html#api-videoGroup-Get_Video_Count
     *
     * @param string $query
     * @return mixed
     */
    public function countVideos($query = NULL)
    {
        $result = $this->cmsRequest('GET', "/counts/videos{$query}", NULL);

        if ($result && !empty($result['count'])) {
            return $result['count'];
        }

        return NULL;
    }
}