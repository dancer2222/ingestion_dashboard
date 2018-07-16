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
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function mediaType()
    {
        return $this->hasOne(MediaType::class, 'media_type_id', 'media_type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productAudiobooks()
    {
        return $this->hasMany(ProductAudioBook::class, 'batch_id', 'id');
    }

    /**
     * @param $id
     * @return null
     */
    public function getAllByBatchId($id)
    {
        return $this->where('id', $id)->first();
    }
}
