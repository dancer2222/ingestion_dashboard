<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MediaMetadata
 * @package App\Models
 */
class MediaMetadata extends Model
{
    /**
     * @var string
     */
    protected $connection = 'mysql_local_ingestion';

    /**
     * @var string
     */
    protected $table = 'media_metadata';

    /**
     * @param $id
     * @param $type
     * @return mixed
     */
    public function getMetadata($id, $type)
    {
        return $this->where('media_id', $id)
            ->where('media_type_id', $type)
            ->select('metadata')
            ->first();
    }
}
