<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
            ->first()->toArray()['name'];

        return count($allInfo) ? $allInfo : null;
    }
}
