<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FailedItems
 * @package App\Models
 */
class FailedItems extends Model
{
    /**
     * @var string
     */
    protected $connection = 'mysql_local_ingestion';

    /**
     * @var string
     */
    protected $table = 'ingestion_failed_items';

    /**
     * @param $id
     * @return array|null
     */
    public function getFailedItems($id)
    {
        $allInfo = $this->where('item_id', $id)->get()->toArray();

        return count($allInfo) ? $allInfo : null;
    }
}
