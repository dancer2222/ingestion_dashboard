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

    /**
     * It returns list of all related batches
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function qaBatches()
    {
        return $this->hasMany(QaBatch::class, 'data_source_provider_id', 'id');
    }

    /**
     * It returns the first found batch
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function qaBatch()
    {
        return $this->hasOne(QaBatch::class, 'data_source_provider_id', 'id');
    }
}
