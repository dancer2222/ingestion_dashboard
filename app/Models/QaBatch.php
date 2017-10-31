<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class QaBatch
 * @package App\Models
 */
class QaBatch extends Model
{
    /**
     * @var string
     */
    protected $table = 'qa_batches';

    /**
     * @param $id
     * @return null
     */
    public function getAllByBatchId($id)
    {
        $allInfo = $this->where('id',$id)->first()->toArray();

        return count($allInfo) ? $allInfo : null;
    }
}
