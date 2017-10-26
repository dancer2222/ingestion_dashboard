<?php

namespace App\Models;

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

        return count($allInfo) ? $allInfo : null;
    }
}
