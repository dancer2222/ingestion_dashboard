<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class QaBatch extends Model
{
    protected $table = 'qa_batches';

    public function getAllByBatchId($id)
    {
        $allInfo = $name = DB::table('qa_batches')
            ->where('id', '=',$id)->get();

        if (count($allInfo) == 0) {
            return $allInfo = null;
        } else {
            return $allInfo;
        }
    }
}
