<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DataSourceProvider extends Model
{
    protected $table = 'data_source_provider';

    public function getDataSourceProviderName($id)
    {
        $allInfo = DB::table('data_source_provider')
            ->select('name')
            ->where('id', '=',$id)
            ->get();

        if (count($allInfo) == 0) {
            return $allInfo = null;
        } else {
            return $allInfo;
        }

    }
}