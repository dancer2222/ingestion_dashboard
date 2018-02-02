<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        return $this->where('id', $id)->first();
    }
}
