<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FailedItems
 * @package App\Models
 */
class FailedItems extends Model
{
    protected $connection = 'ingestion';
    protected $table = 'ingestion_failed_items';

    /**
     * @param $id
     * @param $batch_id
     * @return array|null
     */
    public function getFailedItems($id, $batch_id)
    {
        $allInfo = $this->where('item_id', $id)
            ->where('batch_id', $batch_id)->get()->toArray();

        return count($allInfo) ? $allInfo : null;
    }
}
