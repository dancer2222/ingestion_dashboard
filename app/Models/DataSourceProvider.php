<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class DataSourceProvider
 * @package App\Models
 */
class DataSourceProvider extends Model
{
    /**
     * @var string
     */
    protected $table = 'data_source_provider';

    /**
     * @param $id
     * @return null
     */
    public function getDataSourceProviderName($id)
    {
        $allInfo = DB::table('data_source_provider')
            ->select('name')
            ->where('id', '=',$id)
            ->get();

        return count($allInfo) ? $allInfo : null;
    }
}
