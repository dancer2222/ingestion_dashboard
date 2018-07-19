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
     * @return mixed
     */
    public function getDataSourceProviderName($id)
    {
        return  $this->select('name')
            ->where('id', $id)
            ->first();
    }
}
