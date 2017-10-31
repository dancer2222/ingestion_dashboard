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
        $allInfo = $this->select('name')
            ->where('id',$id)
            ->get()->toArray()[0]['name'];

        return count($allInfo) ? $allInfo : null;
    }
}
